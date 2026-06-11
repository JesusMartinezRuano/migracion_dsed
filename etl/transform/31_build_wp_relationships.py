import pandas as pd

# --------------------------------------------------
# MAPA FILTRO -> MINERAL
# --------------------------------------------------

mf = pd.read_csv("mineral_filtro.csv")

mf["IdFiltro"] = mf["IdFiltro"].astype(int)
mf["IdMineralGen"] = mf["IdMineralGen"].astype(int)

filtro_map = (
    mf[["IdFiltro", "IdMineralGen"]]
    .drop_duplicates()
    .set_index("IdFiltro")["IdMineralGen"]
    .to_dict()
)

# --------------------------------------------------
# FUNCIÓN GENÉRICA
# --------------------------------------------------

def generar_relaciones(fichero_entrada,
                        nombre_ejemplar,
                        fichero_salida):

    df = pd.read_csv(fichero_entrada)

    df["IdFiltro"] = df["IdFiltro"].astype(int)

    df["IdMineralGen"] = df["IdFiltro"].map(filtro_map)

    df = df.dropna(subset=["IdMineralGen"])

    salida = pd.DataFrame({
        "IdMineralGen": df["IdMineralGen"].astype(int),
        nombre_ejemplar: df["IdEjemplar"].astype(int)
    })

    salida = salida.drop_duplicates()

    salida.to_csv(
        fichero_salida,
        index=False,
        encoding="utf-8"
    )

    print(
        f"{fichero_salida}: "
        f"{len(salida):,} relaciones"
    )

# --------------------------------------------------
# FOTOS
# --------------------------------------------------

generar_relaciones(
    "relaciones_mineral_foto_reales.csv",
    "IdFoto",
    "rel_mineral_foto.csv"
)

# --------------------------------------------------
# DOCUMENTOS
# --------------------------------------------------

generar_relaciones(
    "relaciones_mineral_contenido_reales.csv",
    "IdDocumento",
    "rel_mineral_documento.csv"
)

# --------------------------------------------------
# ENLACES
# --------------------------------------------------

generar_relaciones(
    "relaciones_mineral_enlace_reales.csv",
    "IdEnlace",
    "rel_mineral_enlace.csv"
)

print("\nFIN")