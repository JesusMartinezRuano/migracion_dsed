#!/usr/bin/env python3

import pandas as pd
from pathlib import Path

csvs = [
    "wp_minerales.csv",
    "wp_fotos.csv",
    "wp_ejemplares.csv",
    "wp_etsiminas.csv",
    "wp_documentos.csv",
    "wp_enlaces.csv",
    "wp_archivos.csv",
]

for fichero in csvs:

    print()
    print("=" * 80)
    print(fichero)
    print("=" * 80)

    df = pd.read_csv(
        fichero,
        nrows=5
    )

    print()
    print("COLUMNAS")

    for c in df.columns:
        print(" -", c)

    print()
    print("MUESTRA")

    print(df.head(2).T)