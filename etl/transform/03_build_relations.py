#!/usr/bin/env python3

import pyodbc
import pandas as pd

# --------------------------------------------------
# Conexion SQL Server
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
# Cargar relaciones
# --------------------------------------------------

print("Cargando FilConFiltroEjem...")

rel = pd.read_sql("""
SELECT
    IdFiltro,
    IdElemento,
    IdEjemplar
FROM FilConFiltroEjem
""", conn)

print("Cargando FilFiltros...")

filtros = pd.read_sql("""
SELECT
    IdFiltro,
    Nombre
FROM FilFiltros
""", conn)

# --------------------------------------------------
# Separar tipos
# --------------------------------------------------

minerales = rel[rel["IdElemento"] == 28].copy()
fotos     = rel[rel["IdElemento"] == 29].copy()
enlaces   = rel[rel["IdElemento"] == 34].copy()
contenido = rel[rel["IdElemento"] == 26].copy()

print("\n==============================")
print("RESUMEN")
print("==============================")

print("Minerales :", minerales.shape)
print("Fotos     :", fotos.shape)
print("Enlaces   :", enlaces.shape)
print("Contenido :", contenido.shape)

# --------------------------------------------------
# Estadísticas de filtros asociados a minerales
# --------------------------------------------------

print("\n==============================")
print("FILTROS POR MINERAL")
print("==============================")

filtro_stats = minerales.groupby("IdFiltro").size()

print(filtro_stats.describe())

print("\nTOP 20 filtros con más minerales")

print(
    filtro_stats
    .sort_values(ascending=False)
    .head(20)
)

# --------------------------------------------------
# Estadísticas de filtros asociados a fotos
# --------------------------------------------------

print("\n==============================")
print("FILTROS POR FOTO")
print("==============================")

foto_stats = fotos.groupby("IdFiltro").size()

print(foto_stats.describe())

print("\nTOP 20 filtros con más fotos")

print(
    foto_stats
    .sort_values(ascending=False)
    .head(20)
)

# --------------------------------------------------
# Reconstrucción Mineral -> Foto
# --------------------------------------------------

print("\n==============================")
print("GENERANDO RELACIONES")
print("==============================")

rel_mineral_foto = minerales.merge(
    fotos,
    on="IdFiltro",
    suffixes=("_mineral", "_foto")
)

rel_mineral_foto = rel_mineral_foto[
    [
        "IdFiltro",
        "IdEjemplar_mineral",
        "IdEjemplar_foto"
    ]
].rename(
    columns={
        "IdEjemplar_mineral": "IdMineralGen",
        "IdEjemplar_foto": "IdMineralPar"
    }
)

rel_mineral_foto = rel_mineral_foto.merge(
    filtros,
    on="IdFiltro",
    how="left"
)

print("Relaciones generadas:", len(rel_mineral_foto))

# --------------------------------------------------
# Validación ACTINOLITA
# --------------------------------------------------

print("\n==============================")
print("VALIDACION ACTINOLITA")
print("==============================")

actinolita = rel_mineral_foto[
    rel_mineral_foto["IdFiltro"] == 727
]

print(actinolita)

# --------------------------------------------------
# Filtros más utilizados
# --------------------------------------------------

print("\n==============================")
print("TOP 50 FILTROS MAS UTILIZADOS")
print("==============================")

top_filtros = (
    rel.groupby("IdFiltro")
       .size()
       .reset_index(name="Total")
       .merge(filtros, on="IdFiltro", how="left")
       .sort_values("Total", ascending=False)
)

print(top_filtros.head(50))

# --------------------------------------------------
# Exportaciones
# --------------------------------------------------

rel_mineral_foto.to_csv(
    "relaciones_mineral_foto.csv",
    index=False,
    encoding="utf-8"
)

top_filtros.to_csv(
    "top_filtros.csv",
    index=False,
    encoding="utf-8"
)

print("\n==============================")
print("EXPORTADOS")
print("==============================")

print("relaciones_mineral_foto.csv")
print("top_filtros.csv")

# --------------------------------------------------
# Resumen final
# --------------------------------------------------

print("\n==============================")
print("RESUMEN FINAL")
print("==============================")

print(
    "Minerales distintos:",
    rel_mineral_foto["IdMineralGen"].nunique()
)

print(
    "Fotos distintas:",
    rel_mineral_foto["IdMineralPar"].nunique()
)

print(
    "Relaciones:",
    len(rel_mineral_foto)
)

print(
    "Filtros distintos:",
    rel_mineral_foto["IdFiltro"].nunique()
)