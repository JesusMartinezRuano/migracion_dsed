# ETL - Proceso de Extracción, Transformación y Carga

## Introducción

Este documento describe el proceso ETL (Extract, Transform, Load) utilizado durante la migración del sistema SIC/DSED al nuevo entorno WordPress.

El objetivo del ETL fue trasladar toda la información histórica del sistema original manteniendo:

* Integridad de datos.
* Relaciones semánticas.
* Trazabilidad.
* Compatibilidad futura.

---

# Objetivos

El proceso ETL debía permitir:

* Extraer datos desde SQL Server.
* Recuperar imágenes del repositorio documental.
* Transformar estructuras históricas.
* Adaptar datos al modelo WordPress.
* Conservar identificadores históricos.
* Validar la información importada.

---

# Arquitectura ETL

```text
Sistema Original
│
├── SQL Server
│
└── RepoMinerales
       │
       ▼
+-------------------+
|     EXTRACT       |
+-------------------+
       │
       ▼
+-------------------+
|    TRANSFORM      |
+-------------------+
       │
       ▼
+-------------------+
|      LOAD         |
+-------------------+
       │
       ▼
WordPress + MariaDB
```

---

# Estructura del Proyecto

```text
minerales-etl/
│
├── extract/
│
├── transform/
│
├── import/
│
├── sql/
│
├── logs/
│
└── tmp/
```

---

# Fase Extract

## Origen de Datos

### Base de Datos

Origen:

```text
SQL Server
```

Backup utilizado:

```text
minerales_backup_2025_04_27_030004_3900000.bak
```

---

### Repositorio Documental

Origen:

```text
RepoMinerales/
```

Contenido:

```text
Mineral00001.jpg
Mineral00002.jpg
Mineral00003.jpg
...
```

---

# Extracción SQL

## Objetivo

Exportar los datos relevantes a formato CSV.

---

## Entidades Extraídas

### Minerales

Salida:

```text
minerales.csv
```

---

### Ejemplares

Salida:

```text
ejemplares.csv
```

---

### Fotografías

Salida:

```text
fotos.csv
```

---

### Yacimientos

Salida:

```text
yacimientos.csv
```

---

### Museos

Salida:

```text
museos.csv
```

---

### Relaciones

Salida:

```text
rel_mineral.csv
rel_ejemplar.csv
rel_foto.csv
rel_enlace.csv
```

---

# Fase Transform

## Objetivo

Convertir la estructura histórica al modelo WordPress.

---

# Normalización

Durante la transformación se realizaron:

## Limpieza HTML

Eliminación de:

* Etiquetas obsoletas.
* Código ASP embebido.
* Formatos incompatibles.

---

## Codificación

Conversión a:

```text
UTF-8
```

---

## Fechas

Conversión:

```text
dd/mm/yyyy
```

a:

```text
yyyy-mm-dd
```

---

## Valores Nulos

Normalización de:

```text
NULL
''
' '
```

---

# Conservación de Identificadores

Todos los registros conservaron:

```text
legacy_id
```

Ejemplo:

| Origen | Destino        |
| ------ | -------------- |
| 1234   | legacy_id=1234 |

---

# Mapeo de Entidades

## Mineral

Origen:

```text
MINERAL
```

Destino:

```text
post_type = mineral
```

---

## Ejemplar

Origen:

```text
EJEMPLAR
```

Destino:

```text
post_type = ejemplar
```

---

## Yacimiento

Origen:

```text
YACIMIENTO
```

Destino:

```text
post_type = yacimiento
```

---

## Museo

Origen:

```text
MUSEO
```

Destino:

```text
post_type = museo
```

---

## Recursos

Origen:

```text
ENLACE
DOCUMENTO
```

Destino:

```text
post_type = recurso
```

---

# Transformación de Relaciones

## Mineral ↔ Mineral

Generación de:

```text
mineral_relacionado
```

---

## Mineral ↔ Ejemplar

Generación de:

```text
ejemplar_relacionado
```

---

## Mineral ↔ Fotografía

Generación de:

```text
foto_relacionada
```

---

## Recurso ↔ Recurso

Generación de:

```text
recurso_relacionado
```

---

# Fase Load

## Objetivo

Importar los datos transformados a WordPress.

---

# Plugin de Importación

Plugin utilizado:

```text
migracion_dsed
```

Funciones principales:

* Importación de entidades.
* Importación de taxonomías.
* Importación de imágenes.
* Creación de relaciones.
* Validación.

---

# Orden de Carga

La carga se realizó en el siguiente orden.

## 1. Taxonomías

Importación de:

* etiquetas
* clasificaciones

---

## 2. Minerales

Importación de:

```text
minerales.csv
```

---

## 3. Ejemplares

Importación de:

```text
ejemplares.csv
```

---

## 4. Yacimientos

Importación de:

```text
yacimientos.csv
```

---

## 5. Museos

Importación de:

```text
museos.csv
```

---

## 6. Recursos

Importación de:

```text
recursos.csv
```

---

## 7. Fotografías

Importación masiva desde:

```text
RepoMinerales
```

---

## 8. Relaciones

Carga de:

* mineral-mineral
* mineral-ejemplar
* mineral-foto
* foto-foto
* recurso-recurso

---

# Importación de Imágenes

## Procedimiento

1. Localizar fichero físico.
2. Crear attachment WordPress.
3. Generar miniaturas.
4. Registrar metadatos.
5. Asociar al recurso correspondiente.

---

## Metadatos Generados

```text
legacy_filename
_wp_attached_file
_wp_attachment_metadata
```

---

# Validaciones

Tras cada fase se ejecutaron validaciones.

---

## Conteos

Comparación:

```sql
COUNT(*)
```

Origen vs destino.

---

## Integridad

Verificación de:

* IDs huérfanos.
* Relaciones rotas.
* Fotografías inexistentes.

---

## Muestreo Manual

Verificación visual de:

* Minerales.
* Fotografías.
* Relaciones.
* Fichas completas.

---

# Registro de Errores

Los errores detectados se almacenan en:

```text
logs/
```

Ejemplos:

```text
imagenes_no_encontradas.log
relaciones_huerfanas.log
importacion_errores.log
```

---

# Reejecución

El proceso es repetible.

Puede ejecutarse nuevamente:

```text
Extract
→ Transform
→ Load
```

sin perder trazabilidad gracias a:

```text
legacy_id
```

---

# Rendimiento

La estrategia utilizada permitió:

* Importaciones por lotes.
* Reanudación tras fallos.
* Validación incremental.
* Corrección selectiva.

---

# Resultado Final

El proceso ETL permitió migrar completamente:

* Minerales.
* Ejemplares.
* Fotografías.
* Yacimientos.
* Museos.
* Recursos.
* Etiquetas.
* Relaciones.

manteniendo la integridad y trazabilidad de los datos históricos del sistema SIC/DSED.

El resultado es una base WordPress completamente funcional y preparada para futuras ampliaciones.
