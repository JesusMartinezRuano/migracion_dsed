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

# -----------------------------------------
# Minerales
# -----------------------------------------

minerales_sql = pd.read_sql("""
SELECT
    IdMineralGen,
    Titulo
FROM MineralGen
""", conn)

# -----------------------------------------
# Filtros
# -----------------------------------------

filtros = pd.read_sql("""
SELECT
    IdFiltro,
    Nombre
FROM FilFiltros
""", conn)

# -----------------------------------------
# Normalización
# -----------------------------------------

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

# -----------------------------------------
# Cruce directo
# -----------------------------------------

filtros_minerales = minerales_sql.merge(
    filtros,
    left_on="Titulo",
    right_on="Nombre",
    how="inner"
)

print("\nCoincidencias:")
print(len(filtros_minerales))

print("\nPrimeras 20:")
print(
    filtros_minerales.head(20)
)

# -----------------------------------------
# Guardar
# -----------------------------------------

filtros_minerales.to_csv(
    "filtros_minerales.csv",
    index=False,
    encoding="utf-8"
)

print("\nExportado:")
print("filtros_minerales.csv")