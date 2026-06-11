#!/usr/bin/env python3

import pandas as pd
from pathlib import Path

OUTDIR = Path("import")
OUTDIR.mkdir(exist_ok=True)

# =====================================================
# UTILIDADES
# =====================================================

def getcol(df, col):
    if col in df.columns:
        return df[col]
    return ""

# =====================================================
# CARGA
# =====================================================

print("Cargando datasets...")

minerales = pd.read_csv("wp_minerales.csv")
fotos = pd.read_csv("wp_fotos.csv")
ejemplares = pd.read_csv("wp_ejemplares.csv")
etsi = pd.read_csv("wp_etsiminas.csv")
documentos = pd.read_csv("wp_documentos.csv")
enlaces = pd.read_csv("wp_enlaces.csv")
archivos = pd.read_csv("wp_archivos.csv")

# limpiar espacios finales de nombres de columnas
for df in [minerales, fotos, ejemplares, etsi, documentos, enlaces, archivos]:
    df.columns = df.columns.str.strip()

# =====================================================
# MINERALES
# =====================================================

print("Construyendo minerales...")

import_minerales = pd.DataFrame()

import_minerales["legacy_id"] = getcol(minerales, "IdMineralGen")
import_minerales["post_title"] = getcol(minerales, "Titulo")

import_minerales["descripcion"] = getcol(minerales, "Descripcion")
import_minerales["formula"] = getcol(minerales, "Formula")
import_minerales["clasificacion"] = getcol(minerales, "Clasificacion")
import_minerales["aplicacion"] = getcol(minerales, "Aplicacion")

import_minerales["peso_especifico"] = getcol(minerales, "peso")
import_minerales["dureza"] = getcol(minerales, "Dureza")

import_minerales["etimologia"] = getcol(minerales, "Etimologia")
import_minerales["variedades"] = getcol(minerales, "Variedades")
import_minerales["yacimientos"] = getcol(minerales, "Yacimiento")

import_minerales.to_csv(
    OUTDIR / "import_minerales.csv",
    index=False,
    encoding="utf-8"
)

print("  ", len(import_minerales), "minerales")

# =====================================================
# EJEMPLARES ETSI
# =====================================================

print("Construyendo ejemplares...")

ejemplares = ejemplares.reset_index(drop=True)
etsi = etsi.reset_index(drop=True)

n = min(len(ejemplares), len(etsi))

ejemplares = ejemplares.iloc[:n]
etsi = etsi.iloc[:n]

import_ejemplares = pd.DataFrame()

import_ejemplares["legacy_id"] = getcol(ejemplares, "IdMineralPar")
import_ejemplares["post_title"] = getcol(ejemplares, "Titulo")

import_ejemplares["descripcion"] = getcol(ejemplares, "Descripcion")
import_ejemplares["lugar"] = getcol(ejemplares, "Lugar")
import_ejemplares["sic_resumen"] = getcol(ejemplares, "SicResumen")
import_ejemplares["procedencia"] = getcol(ejemplares, "Procedencia")

import_ejemplares["codigo"] = getcol(etsi, "Código")
import_ejemplares["coleccion"] = getcol(etsi, "Colección")

import_ejemplares["mina_cantera"] = getcol(etsi, "Mina o cantera")

import_ejemplares["mineral_principal"] = getcol(
    etsi,
    "Mineral principal"
)

import_ejemplares["minerales_asociados"] = getcol(
    etsi,
    "Minerales asociados"
)

import_ejemplares["municipio"] = getcol(etsi, "Municipio")
import_ejemplares["municipio_antiguo"] = getcol(
    etsi,
    "Municipio antiguo"
)

import_ejemplares["provincia"] = getcol(etsi, "Provincia")
import_ejemplares["region"] = getcol(etsi, "Región")
import_ejemplares["region_antigua"] = getcol(
    etsi,
    "Región antigua"
)

import_ejemplares["pais"] = getcol(etsi, "País")

import_ejemplares["clasificacion_quimica"] = getcol(
    etsi,
    "Clasificación química"
)

import_ejemplares["sistema_cristalino"] = getcol(
    etsi,
    "Sistema crist"
)

import_ejemplares["variedad"] = getcol(
    etsi,
    "Variedad"
)

import_ejemplares["museo"] = getcol(
    etsi,
    "Museo"
)

import_ejemplares["vitrina"] = getcol(
    etsi,
    "Vitrina"
)

import_ejemplares["medida_x"] = getcol(
    etsi,
    "Medida en mm"
)

import_ejemplares["medida_y"] = getcol(
    etsi,
    "Medida en mm1"
)

import_ejemplares["medida_z"] = getcol(
    etsi,
    "Medida en mm2"
)

import_ejemplares.to_csv(
    OUTDIR / "import_ejemplares.csv",
    index=False,
    encoding="utf-8"
)

print("  ", len(import_ejemplares), "ejemplares")

# =====================================================
# DOCUMENTOS
# =====================================================

print("Construyendo documentos...")

import_documentos = pd.DataFrame()

import_documentos["legacy_id"] = getcol(documentos, "IdContenido")
import_documentos["post_title"] = getcol(documentos, "Titulo")
import_documentos["contenido"] = getcol(documentos, "Descripcion")
import_documentos["fecha"] = getcol(documentos, "Fecha")
import_documentos["fichero"] = getcol(documentos, "Fichero")

print("DOCUMENTOS DATAFRAME:", len(import_documentos))
print("DOCUMENTOS ORIGEN:", len(documentos))

import_documentos.to_csv(
    OUTDIR / "import_documentos.csv",
    index=False,
    encoding="utf-8"
)

# =====================================================
# ENLACES
# =====================================================

print("Construyendo enlaces...")

import_enlaces = pd.DataFrame()

import_enlaces["legacy_id"] = getcol(enlaces, "IdEnlace")
import_enlaces["post_title"] = getcol(enlaces, "Titulo")
import_enlaces["descripcion"] = getcol(enlaces, "Descripcion")
import_enlaces["url"] = getcol(enlaces, "Enlace")

import_enlaces.to_csv(
    OUTDIR / "import_enlaces.csv",
    index=False,
    encoding="utf-8"
)

# =====================================================
# MEDIA
# =====================================================

print("Construyendo media...")

import_media = pd.DataFrame()

import_media["legacy_id"] = getcol(archivos, "IdArchivo")
import_media["nombre"] = getcol(archivos, "Nombre")
import_media["archivo"] = getcol(archivos, "Url")
import_media["extension"] = getcol(archivos, "Extension")
import_media["titulo"] = getcol(archivos, "Titulo")
import_media["descripcion"] = getcol(archivos, "Descripcion")
import_media["tamanyo"] = getcol(archivos, "Tamanyo")

import_media.to_csv(
    OUTDIR / "import_media.csv",
    index=False,
    encoding="utf-8"
)

# =====================================================
# FOTOS / RECURSOS MINERALÓGICOS
# =====================================================

print("Construyendo recursos MineralPar...")

import_fotos = pd.DataFrame()

import_fotos["legacy_id"] = getcol(fotos, "IdMineralPar")
import_fotos["titulo"] = getcol(fotos, "Titulo")
import_fotos["descripcion"] = getcol(fotos, "Descripcion")

import_fotos["foto_idarchivo"] = getcol(fotos, "Foto")

import_fotos["lugar"] = getcol(fotos, "Lugar")
import_fotos["sic_resumen"] = getcol(fotos, "SicResumen")
import_fotos["fecha_foto"] = getcol(fotos, "FecFoto")
import_fotos["autor_foto"] = getcol(fotos, "AutorFoto")
import_fotos["procedencia"] = getcol(fotos, "Procedencia")

import_fotos.to_csv(
    OUTDIR / "import_fotos.csv",
    index=False,
    encoding="utf-8"
)

# =====================================================
# RESUMEN
# =====================================================

print()
print("=" * 60)
print("IMPORT TABLES GENERADAS")
print("=" * 60)

for f in sorted(OUTDIR.glob("*.csv")):
    print(f.name)

print()
print("Proceso completado.")