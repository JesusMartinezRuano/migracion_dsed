import pandas as pd
from pathlib import Path

repo = Path("/home/deadmin/RepoMinerales")

archivos = pd.read_csv(
    "wp_archivos.csv",
    dtype=str
)

rows = []

for _, r in archivos.iterrows():

    nombre_fisico = str(r["Url"]).strip()

    fichero = repo / nombre_fisico

    if fichero.exists():

        rows.append({
            "IdArchivo": r["IdArchivo"],
            "title": r["Nombre"],
            "extension": r["Extension"],
            "file_path": str(fichero),
            "legacy_name": nombre_fisico
        })

media = pd.DataFrame(rows)

media.to_csv(
    "wp_media_import.csv",
    index=False,
    encoding="utf-8"
)

print()
print("Media encontrados:", len(media))
print()