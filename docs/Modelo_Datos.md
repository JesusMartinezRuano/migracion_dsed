# Modelo de Datos

## Introducción

Este documento describe el modelo de datos implantado tras la migración del sistema SIC/DSED al nuevo entorno WordPress.

El objetivo principal del modelo es conservar la estructura conceptual del sistema original, utilizando mecanismos estándar de WordPress para garantizar mantenibilidad y compatibilidad futura.

---

# Principios de Diseño

Durante la migración se adoptaron los siguientes principios:

* Preservar la información histórica.
* Mantener las relaciones existentes.
* Utilizar estructuras estándar de WordPress.
* Evitar modificaciones del núcleo.
* Facilitar futuras ampliaciones.
* Permitir integraciones mediante API REST.

---

# Arquitectura de Persistencia

La información se almacena en:

```text
MariaDB
│
├── wp_posts
├── wp_postmeta
├── wp_terms
├── wp_term_taxonomy
├── wp_term_relationships
├── wp_users
└── tablas auxiliares WordPress
```

---

# Entidades Principales

## Mineral

Representa una especie mineral.

### Implementación

```text
post_type = mineral
```

### Tabla principal

```text
wp_posts
```

### Campos WordPress

| Campo        | Descripción           |
| ------------ | --------------------- |
| ID           | Identificador interno |
| post_title   | Nombre mineral        |
| post_content | Descripción           |
| post_status  | Estado                |
| post_type    | mineral               |

### Metadatos

| Meta Key           | Descripción             |
| ------------------ | ----------------------- |
| legacy_id          | Identificador histórico |
| formula            | Fórmula química         |
| sistema_cristalino | Sistema cristalino      |
| dureza             | Escala Mohs             |
| densidad           | Densidad                |
| brillo             | Tipo de brillo          |
| color              | Color principal         |
| raya               | Color de raya           |

---

## Ejemplar

Representa una pieza física de colección.

### Implementación

```text
post_type = ejemplar
```

### Metadatos

| Meta Key      | Descripción       |
| ------------- | ----------------- |
| legacy_id     | ID histórico      |
| codigo        | Código inventario |
| coleccion     | Colección         |
| procedencia   | Procedencia       |
| ubicacion     | Ubicación         |
| observaciones | Observaciones     |

---

## Yacimiento

Representa una localización mineralógica.

### Implementación

```text
post_type = yacimiento
```

### Metadatos

| Meta Key    | Descripción             |
| ----------- | ----------------------- |
| municipio   | Municipio               |
| provincia   | Provincia               |
| comunidad   | Comunidad Autónoma      |
| pais        | País                    |
| coordenadas | Coordenadas geográficas |

---

## Museo

Representa instituciones y colecciones.

### Implementación

```text
post_type = museo
```

### Metadatos

| Meta Key  | Descripción |
| --------- | ----------- |
| direccion | Dirección   |
| localidad | Localidad   |
| provincia | Provincia   |
| web       | Sitio web   |

---

## Recurso

Representa documentación auxiliar.

### Implementación

```text
post_type = recurso
```

### Metadatos

| Meta Key   | Descripción              |
| ---------- | ------------------------ |
| url_origen | URL original             |
| autor      | Autor                    |
| referencia | Referencia bibliográfica |

---

# Fotografías

Las fotografías se almacenan utilizando la estructura estándar WordPress.

### Implementación

```text
post_type = attachment
```

### Tabla

```text
wp_posts
```

### Metadatos relevantes

| Meta Key                | Descripción         |
| ----------------------- | ------------------- |
| _wp_attached_file       | Ruta física         |
| legacy_filename         | Nombre histórico    |
| _wp_attachment_metadata | Metadatos WordPress |

---

# Taxonomías

Las taxonomías sustituyen las etiquetas históricas DSED.

---

## Etiquetas

```text
taxonomy = etiqueta
```

Uso:

* Clasificación temática.
* Filtrado.
* Navegación.

---

## Clasificaciones

```text
taxonomy = clasificacion
```

Uso:

* Agrupaciones funcionales.
* Categorías documentales.

---

# Relaciones

Las relaciones se almacenan mediante metadatos.

---

## Mineral ↔ Mineral

### Meta

```text
mineral_relacionado
```

### Tipo

Relación múltiple.

### Ejemplo

```text
Calcita
 ├─ Dolomita
 ├─ Aragonito
 └─ Magnesita
```

---

## Mineral ↔ Ejemplar

### Meta

```text
ejemplar_relacionado
```

### Tipo

Uno a muchos.

### Ejemplo

```text
Calcita
 ├─ Ejemplar 001
 ├─ Ejemplar 002
 └─ Ejemplar 003
```

---

## Mineral ↔ Fotografía

### Meta

```text
foto_relacionada
```

### Tipo

Uno a muchos.

---

## Fotografía ↔ Fotografía

### Meta

```text
foto_relacionada
```

### Tipo

Muchos a muchos.

---

## Recurso ↔ Recurso

### Meta

```text
recurso_relacionado
```

### Tipo

Muchos a muchos.

---

# Identificadores Históricos

Todas las entidades migradas conservan:

```text
legacy_id
```

Este campo permite:

* Auditoría.
* Trazabilidad.
* Reimportaciones.
* Validaciones.

Ejemplo:

| Sistema   | ID   |
| --------- | ---- |
| SIC       | 1234 |
| WordPress | 9876 |

```text
legacy_id = 1234
```

---

# Modelo Lógico

```text
Mineral
│
├── Fotografías
│
├── Ejemplares
│
├── Minerales Relacionados
│
├── Etiquetas
│
└── Recursos
```

---

# Modelo Físico

```text
wp_posts
│
├── mineral
├── ejemplar
├── yacimiento
├── museo
├── recurso
└── attachment
```

```text
wp_postmeta
│
├── legacy_id
├── formula
├── dureza
├── brillo
├── codigo
├── procedencia
├── foto_relacionada
├── mineral_relacionado
└── recurso_relacionado
```

```text
wp_terms
│
└── etiquetas y clasificaciones
```

---

# Integridad de Datos

Durante la migración se verificó:

* Correspondencia de registros.
* Integridad de relaciones.
* Existencia de imágenes.
* Coherencia de taxonomías.
* Conservación de identificadores históricos.

---

# Extensibilidad

El modelo permite incorporar:

* Nuevos tipos documentales.
* Nuevos metadatos.
* Nuevas taxonomías.
* Nuevas relaciones.
* Integraciones externas.

Sin modificar la estructura principal.

---

# Resumen

El modelo de datos implementado en WordPress conserva la semántica y organización del sistema SIC/DSED original utilizando:

* Custom Post Types.
* Taxonomías WordPress.
* Metadatos estándar.
* Relaciones basadas en postmeta.
* Biblioteca multimedia nativa.

La solución proporciona una estructura flexible, mantenible y preparada para futuras ampliaciones del repositorio mineralógico.
