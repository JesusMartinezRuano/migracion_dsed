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

par = pd.read_sql("""
SELECT
    IdMineralPar,
    Titulo
FROM MineralPar
""", conn)

gen = pd.read_sql("""
SELECT
    IdMineralGen,
    Titulo
FROM MineralGen
""", conn)

minerales = [
    m.upper().strip()
    for m in gen["Titulo"]
]

def contiene_mineral(txt):

    txt = str(txt).upper()

    for m in minerales:
        if m in txt:
            return True

    return False

par["CoincideTitulo"] = (
    par["Titulo"]
    .apply(contiene_mineral)
)

print(
    par["CoincideTitulo"]
      .value_counts()
)