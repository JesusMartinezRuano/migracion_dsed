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
SELECT TOP 5 *
FROM MineralGen
""", conn)

print(df.columns.tolist())
print(df.head())

