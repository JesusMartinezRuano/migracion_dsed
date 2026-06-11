import csv

with open(
    'wp_fotos.csv',
    encoding='utf8',
    newline=''
) as fin:

    r = csv.DictReader(fin)

    rows = []

    for row in r:

        rows.append({
            'legacy_id'      : row['IdMineralPar'],
            'titulo'         : row['Titulo'],
            'descripcion'    : row['Descripcion'],
            'fecha_creacion' : row['FechaCreacion'],
            'foto_id'        : row['Foto'],
            'lugar'          : row['Lugar'],
            'sic_resumen'    : row['SicResumen'],
            'fecha_foto'     : row['FecFoto'],
            'autor_foto'     : row['AutorFoto'],
            'procedencia'    : row['Procedencia'],
            'id_usuario'     : row['IdUsuario']
        })

with open(
    'wp_recursos.csv',
    'w',
    encoding='utf8',
    newline=''
) as fout:

    campos = [
        'legacy_id',
        'titulo',
        'descripcion',
        'fecha_creacion',
        'foto_id',
        'lugar',
        'sic_resumen',
        'fecha_foto',
        'autor_foto',
        'procedencia',
        'id_usuario'
    ]

    w = csv.DictWriter(
        fout,
        fieldnames=campos
    )

    w.writeheader()
    w.writerows(rows)

print(
    f"Recursos generados: {len(rows)}"
)