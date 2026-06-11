#!/usr/bin/env python3

import pyodbc
import pandas as pd

# --------------------------------------------------
# CONEXION
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
# EXPORTADOR GENERICO
# --------------------------------------------------

def exportar(sql, fichero):

    print(f"Exportando {fichero}...")

    df = pd.read_sql(sql, conn)

    df.to_csv(
        fichero,
        index=False,
        encoding="utf-8"
    )

    print(
        f"  {len(df)} registros"
    )

    return df

# --------------------------------------------------
# MINERALES
# --------------------------------------------------

minerales = exportar("""

SELECT *
FROM MineralGen

""",
"wp_minerales.csv")

# --------------------------------------------------
# FOTOS
# --------------------------------------------------

fotos = exportar("""

SELECT *
FROM MineralPar

""",
"wp_fotos.csv")

# --------------------------------------------------
# EJEMPLARES ETSI
# --------------------------------------------------

ejemplares = exportar("""

SELECT *
FROM MineralPar2

""",
"wp_ejemplares.csv")

# --------------------------------------------------
# FICHAS ETSI
# --------------------------------------------------

etsi = exportar("""

SELECT *
FROM mineralesETSIMinas

""",
"wp_etsiminas.csv")

# --------------------------------------------------
# DOCUMENTOS WEB
# --------------------------------------------------

documentos = exportar("""

SELECT *
FROM Contenido

""",
"wp_documentos.csv")

# --------------------------------------------------
# ENLACES
# --------------------------------------------------

enlaces = exportar("""

SELECT *
FROM Enlace

""",
"wp_enlaces.csv")

# --------------------------------------------------
# ARCHIVOS
# --------------------------------------------------

archivos = exportar("""

SELECT *
FROM Archivos

""",
"wp_archivos.csv")

# --------------------------------------------------
# FILTROS
# --------------------------------------------------

filtros = exportar("""

SELECT *
FROM FilFiltros

""",
"wp_filtros.csv")

# --------------------------------------------------
# RELACIONES
# --------------------------------------------------

rel = exportar("""

SELECT *
FROM FilConFiltroEjem

""",
"wp_relaciones.csv")

# --------------------------------------------------
# RESUMEN
# --------------------------------------------------

print()
print("===================================")
print("RESUMEN EXPORTACION")
print("===================================")

print("Minerales      :", len(minerales))
print("Fotos          :", len(fotos))
print("Ejemplares     :", len(ejemplares))
print("ETSI           :", len(etsi))
print("Documentos     :", len(documentos))
print("Enlaces        :", len(enlaces))
print("Archivos       :", len(archivos))
print("Filtros        :", len(filtros))
print("Relaciones     :", len(rel))

print()
print("EXPORTACION COMPLETADA")