#!/usr/bin/env python3

import pandas as pd

minerales = pd.read_csv("import/import_minerales.csv")
ejemplares = pd.read_csv("import/import_ejemplares.csv")

minerales["k"] = (
    minerales["post_title"]
    .fillna("")
    .str.strip()
    .str.upper()
)

ejemplares["k"] = (
    ejemplares["mineral_principal"]
    .fillna("")
    .str.strip()
    .str.upper()
)

minerales_map = {}

for _, row in minerales.iterrows():
    minerales_map[row["k"]] = row["legacy_id"]

rel = []

for _, row in ejemplares.iterrows():

    k = row["k"]

    if k not in minerales_map:
        continue

    rel.append({
        "mineral_legacy_id": int(float(minerales_map[k])),
        "ejemplar_legacy_id": int(float(row["legacy_id"]))
    })

rel_df = pd.DataFrame(rel)

rel_df.to_csv(
    "rel_mineral_ejemplar.csv",
    index=False
)

print()
print("Relaciones generadas:", len(rel_df))
print()