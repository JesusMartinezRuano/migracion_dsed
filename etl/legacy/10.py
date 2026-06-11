#!/usr/bin/env python3

import pyodbc
import pandas as pd
import unicodedata

# --------------------------------------------------
# Normalización
# --------------------------------------------------

def normalizar(txt):

    if txt is None:
        return ""

    txt = str(txt).upper().strip()

    txt = ''.join(
        c for c in unicodedata.normalize('NFD', txt)
        if unicodedata.category(c) != 'Mn'
    )

    txt = " ".join(txt.split())

    return txt

# --------------------------------------------------
# Conexión
# --------------------------------------------------

conn = pyodbc.connect(
    "DRIVER={ODBC Driver 18 for SQL Server};"
    "SERVER=localhost,1433;"
    "DATABASE=minerales_legacy;"
    "UID=sa;"
    "PWD=Liti_passwd123!;"
    "TrustServerCertificate=yes;"
)

# --------------------------------------------------
# Cargar datos
# --------------------------------------------------

minerales = pd.read_sql("""
SELECT
    IdMineralGen,
    Titulo
FROM MineralGen
""", conn)

filtros = pd.read_sql("""
SELECT
    IdFiltro,
    Nombre
FROM FilFiltros
""", conn)

# --------------------------------------------------
# Normalizar
# --------------------------------------------------

minerales["TituloNorm"] = (
    minerales["Titulo"]
    .apply(normalizar)
)

filtros["NombreNorm"] = (
    filtros["Nombre"]
    .apply(normalizar)
)

# --------------------------------------------------
# Coincidencia exacta normalizada
# --------------------------------------------------

exactas = minerales.merge(
    filtros,
    left_on="TituloNorm",
    right_on="NombreNorm",
    how="inner"
)

exactas["TipoRelacion"] = "directo"

print()
print("Coincidencias exactas:")
print(len(exactas))

# --------------------------------------------------
# Faltantes
# --------------------------------------------------

faltantes = minerales[
    ~minerales["IdMineralGen"].isin(
        exactas["IdMineralGen"]
    )
].copy()

print()
print("Faltantes tras normalización:")
print(len(faltantes))

# --------------------------------------------------
# Reglas de grupo conocidas
# --------------------------------------------------

grupos = {
    "GRANATE ALMANDINO": "GRANATE",
    "GRANATE PIROPO": "GRANATE",
    "GRANATE ANDRADITA": "GRANATE",
    "GRANATE GROSULARIA": "GRANATE",

    "TURMALINA ELBAITA": "TURMALINA",
    "TURMALINA CHORLO": "TURMALINA",

    "PLAGIOCLASA ALBITA": "PLAGIOCLASA",
    "PLAGIOCLASA ANORTITA": "PLAGIOCLASA",

    "ESTIBINA": "ANTIMONITA O ESTIBINA",
    "BARITINA": "BARITA O BARITINA",
    "CIANITA": "CIANITA O DISTENA",
}

# --------------------------------------------------
# Coincidencias por grupo/sinónimo
# --------------------------------------------------

extra = []

for _, m in faltantes.iterrows():

    titulo = m["TituloNorm"]

    if titulo not in grupos:
        continue

    objetivo = normalizar(
        grupos[titulo]
    )

    candidatos = filtros[
        filtros["NombreNorm"] == objetivo
    ]

    if len(candidatos) == 0:
        continue

    for _, f in candidatos.iterrows():

        extra.append({
            "IdMineralGen": m["IdMineralGen"],
            "Titulo": m["Titulo"],
            "IdFiltro": f["IdFiltro"],
            "Nombre": f["Nombre"],
            "TipoRelacion": "grupo/sinonimo"
        })

extra = pd.DataFrame(extra)

print()
print("Coincidencias grupo/sinónimo:")
print(len(extra))

# --------------------------------------------------
# Resultado final
# --------------------------------------------------

resultado = pd.concat([
    exactas[
        [
            "IdMineralGen",
            "Titulo",
            "IdFiltro",
            "Nombre",
            "TipoRelacion"
        ]
    ],
    extra
])

resultado = resultado.sort_values(
    "IdMineralGen"
)

print()
print("Cobertura total:")
print(len(resultado))

print()
print("Minerales sin resolver:")

resueltos = set(
    resultado["IdMineralGen"]
)

pendientes = minerales[
    ~minerales["IdMineralGen"].isin(
        resueltos
    )
]

print(
    pendientes[
        [
            "IdMineralGen",
            "Titulo"
        ]
    ]
)

print()
print(
    "Pendientes:",
    len(pendientes)
)

# --------------------------------------------------
# Exportar
# --------------------------------------------------

resultado.to_csv(
    "mineral_filtro.csv",
    index=False,
    encoding="utf-8"
)

pendientes.to_csv(
    "minerales_pendientes.csv",
    index=False,
    encoding="utf-8"
)

print()
print("Exportado:")
print("  mineral_filtro.csv")
print("  minerales_pendientes.csv")