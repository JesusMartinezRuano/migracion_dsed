import pyodbc
import pandas as pd

conn = pyodbc.connect(
    "DRIVER={ODBC Driver 18 for SQL Server};"
    "SERVER=localhost,1433;"
    "DATABASE=minerales_legacy;"
    "UID=sa;"
    "PWD=Liti_passwd123!;"
    "TrustServerCertificate=yes;"
)

# -----------------------------
# Tablas base
# -----------------------------

minerales_sql = pd.read_sql("""
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

rel = pd.read_sql("""
SELECT
    IdFiltro,
    IdElemento,
    IdEjemplar
FROM FilConFiltroEjem
""", conn)

# -----------------------------
# Normalización
# -----------------------------

minerales_sql["Titulo"] = (
    minerales_sql["Titulo"]
    .astype(str)
    .str.strip()
    .str.upper()
)

filtros["Nombre"] = (
    filtros["Nombre"]
    .astype(str)
    .str.strip()
    .str.upper()
)

# -----------------------------
# Filtros mineralógicos
# -----------------------------

filtros_minerales = minerales_sql.merge(
    filtros,
    left_on="Titulo",
    right_on="Nombre",
    how="inner"
)

print("Filtros mineralógicos:", len(filtros_minerales))

# -----------------------------
# Relaciones asociadas SOLO
# a esos filtros
# -----------------------------

ids_filtros = set(
    filtros_minerales["IdFiltro"]
)

rel_filtradas = rel[
    rel["IdFiltro"].isin(ids_filtros)
]

print("Relaciones filtradas:", len(rel_filtradas))

# -----------------------------
# Fotos
# -----------------------------

fotos = rel_filtradas[
    rel_filtradas["IdElemento"] == 29
]

print("Fotos relacionadas:", len(fotos))
print(
    "Fotos distintas:",
    fotos["IdEjemplar"].nunique()
)

# -----------------------------
# Enlaces
# -----------------------------

enlaces = rel_filtradas[
    rel_filtradas["IdElemento"] == 34
]

print("Enlaces relacionados:", len(enlaces))

# -----------------------------
# Contenido
# -----------------------------

contenido = rel_filtradas[
    rel_filtradas["IdElemento"] == 26
]

print("Contenido relacionado:", len(contenido))

# -----------------------------
# Exportaciones
# -----------------------------

fotos.to_csv(
    "relaciones_mineral_foto_reales.csv",
    index=False
)

enlaces.to_csv(
    "relaciones_mineral_enlace_reales.csv",
    index=False
)

contenido.to_csv(
    "relaciones_mineral_contenido_reales.csv",
    index=False
)

print("Exportado")

faltantes = minerales_sql[
    ~minerales_sql["Titulo"].isin(
        filtros_minerales["Titulo"]
    )
]

print(faltantes[["IdMineralGen","Titulo"]])
print("Total:", len(faltantes))
