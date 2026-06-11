#!/usr/bin/env python3

import pandas as pd

print("Cargando datos...")

# -----------------------------------------
# Relaciones mineral-foto
# -----------------------------------------

rel = pd.read_csv(
    "relaciones_mineral_foto_reales.csv"
)

# -----------------------------------------
# Diccionario mineral-filtro
# -----------------------------------------

mf = pd.read_csv(
    "mineral_filtro.csv"
)

# -----------------------------------------
# Fotos por filtro
# -----------------------------------------

estadisticas = (
    rel.groupby("IdFiltro")
       .size()
       .reset_index(name="NumFotos")
)

# -----------------------------------------
# Añadir nombres
# -----------------------------------------

estadisticas = estadisticas.merge(
    mf[
        [
            "IdFiltro",
            "Titulo",
            "TipoRelacion"
        ]
    ],
    on="IdFiltro",
    how="left"
)

# -----------------------------------------
# Ordenar
# -----------------------------------------

estadisticas = estadisticas.sort_values(
    "NumFotos",
    ascending=False
)

# -----------------------------------------
# Mostrar TOP 50
# -----------------------------------------

print("\nTOP 50 MINERALES POR NUMERO DE FOTOS\n")

print(
    estadisticas[
        [
            "IdFiltro",
            "Titulo",
            "NumFotos",
            "TipoRelacion"
        ]
    ]
    .head(50)
    .to_string(index=False)
)

# -----------------------------------------
# Estadísticas generales
# -----------------------------------------

print("\nRESUMEN\n")

print(
    "Minerales con fotos:",
    estadisticas["IdFiltro"].nunique()
)

print(
    "Total relaciones:",
    estadisticas["NumFotos"].sum()
)

print(
    "Media fotos/mineral:",
    round(
        estadisticas["NumFotos"].mean(),
        2
    )
)

print(
    "Máximo fotos:",
    estadisticas["NumFotos"].max()
)

print(
    "Mínimo fotos:",
    estadisticas["NumFotos"].min()
)

# -----------------------------------------
# Exportar
# -----------------------------------------

estadisticas.to_csv(
    "estadisticas_fotos_por_mineral.csv",
    index=False,
    encoding="utf-8"
)

print("\nExportado:")
print("estadisticas_fotos_por_mineral.csv")