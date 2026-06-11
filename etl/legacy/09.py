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

filtros = pd.read_sql("""
SELECT IdFiltro, Nombre
FROM FilFiltros
""", conn)

filtros["Nombre"] = (
    filtros["Nombre"]
    .astype(str)
    .str.upper()
)

busquedas = [
    "GRANATE",
    "TURMALINA",
    "PLAGIOCLASA",
    "ARSEN",
    "ANTIMON",
    "CORIND",
    "BARIT",
    "OPALO",
    "CIANITA",
]

for b in busquedas:
    print("\n===================")
    print(b)
    print("===================")

    print(
        filtros[
            filtros["Nombre"].str.contains(
                b,
                na=False
            )
        ][["IdFiltro","Nombre"]]
    )