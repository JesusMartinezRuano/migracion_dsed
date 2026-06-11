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
SELECT Titulo
FROM MineralGen
""", conn)

minerales = [
    str(x).upper().strip()
    for x in gen["Titulo"]
]

def contiene_mineral(txt):

    txt = str(txt).upper()

    for m in minerales:
        if m in txt:
            return True

    return False

no = par[
    ~par["Titulo"].apply(contiene_mineral)
]

print(no.shape)

print(
    no["Titulo"]
      .value_counts()
      .head(200)
)

no.to_csv(
    "mineralpar_sin_mineral.csv",
    index=False
)