import pandas as pd

filtros = pd.read_csv(
    "../minerales-export/export/FilFiltros.csv",
    sep=";",
    header=None,
    engine="python"
)

print(filtros.shape)
print(filtros.head())