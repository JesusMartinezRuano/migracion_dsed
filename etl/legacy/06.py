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

minerales["Titulo"] = minerales["Titulo"].str.strip().str.upper()
filtros["Nombre"] = filtros["Nombre"].str.strip().str.upper()

coincidencias = minerales.merge(
    filtros,
    left_on="Titulo",
    right_on="Nombre",
    how="inner"
)

print("Coincidencias:", len(coincidencias))
print()
print(coincidencias.head(50))

coincidencias.to_csv(
    "mineral_filtro_directo.csv",
    index=False
)