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

df = pd.read_sql("""
SELECT
    IdMineralPar,
    Titulo
FROM MineralPar
""", conn)

print(df.shape)

print("\nPrimeros 50:")
print(df["Titulo"].head(50))

print("\nÚltimos 50:")
print(df["Titulo"].tail(50))