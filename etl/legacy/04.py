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
    Nombre
FROM MineralGen
""", conn)

print(minerales.head())
print(minerales.columns)
print(minerales.shape)