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

tablas = [
    "MineralGen",
    "MineralPar",
    "MineralPar2",
    "mineralesETSIMinas",
    "Archivos",
    "Enlace",
    "Contenido",
    "FilFiltros",
    "FilConFiltroEjem"
]

for tabla in tablas:
    n = pd.read_sql(
        f"SELECT COUNT(*) AS n FROM {tabla}",
        conn
    ).iloc[0]["n"]

    print(f"{tabla:20} {n}")