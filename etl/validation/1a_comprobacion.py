import pandas as pd

f = pd.read_csv(
    "../minerales-export/export/FilConFiltroEjem.csv",
    sep=";",
    header=None,
    engine="python"
)

print(f.shape)
print(f.head())