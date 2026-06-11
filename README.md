# Migración SIC/DSED Minerales a WordPress

## Descripción

Este proyecto tiene como objetivo la migración completa del sistema histórico SIC/DSED de gestión de minerales hacia una plataforma moderna basada en WordPress.

La migración conserva:

* Información mineralógica.
* Ejemplares de colección.
* Fotografías.
* Yacimientos.
* Museos.
* Enlaces documentales.
* Taxonomías y clasificaciones.
* Relaciones semánticas entre recursos.
* Modelo de navegación y búsqueda del SIC original.

El sistema original estaba basado en:

* ASP clásico.
* SQL Server.
* Repositorio documental externo.
* Aplicaciones DSEDSAU, DSEDCurso, DSEDWeb y SIC.

El sistema destino utiliza:

* WordPress.
* MariaDB.
* Docker.
* Plugin de migración personalizado.

---

# Objetivos

1. Modernizar la plataforma tecnológica.
2. Eliminar dependencias de ASP clásico.
3. Preservar la información histórica.
4. Mantener la estructura de relaciones existente.
5. Facilitar futuras ampliaciones.
6. Simplificar tareas de administración y mantenimiento.

---

# Arquitectura origen

## Componentes

### SQL Server

Almacenamiento de:

* Metadatos.
* Usuarios.
* Etiquetas.
* Relaciones.
* Configuración.

### Repositorio documental

Almacenamiento de:

* Imágenes.
* PDF.
* Documentos.
* Recursos asociados.

### SIC

Portal público de consulta.

### DSEDCurso

Gestión de contenidos.

### DSEDSAU

Administración de usuarios y grupos.

### DSEDWeb

Gestión avanzada de recursos.

---

# Arquitectura destino

## WordPress

Gestión de contenidos.

## MariaDB

Persistencia de datos.

## Plugin Migración DSED

Importadores.

Relaciones.

Componentes frontend.

## Mediateca WordPress

Almacenamiento de imágenes y recursos.

---

# Tipos de contenido migrados

## Mineral

Representa una especie mineral.

Campos principales:

* Nombre
* Fórmula
* Sistema cristalino
* Dureza
* Densidad
* Brillo
* Color

## Ejemplar

Representa una pieza concreta.

Campos principales:

* Código
* Procedencia
* Colección
* Ubicación

## Yacimiento

Información geológica de procedencia.

## Museo

Instituciones y colecciones.

## Recursos

Documentación complementaria.

---

# Relaciones migradas

## Mineral ↔ Mineral

Minerales relacionados.

## Mineral ↔ Ejemplar

Ejemplares asociados.

## Mineral ↔ Fotografía

Fotografías asociadas.

## Fotografía ↔ Fotografía

Imágenes relacionadas.

## Recurso ↔ Recurso

Documentación relacionada.

---

# Estructura del proyecto

```text
migracion_dsed/
│
├── docker/
│
├── wordpress/
│
├── plugin/
│   └── migracion_dsed/
│
├── minerales-etl/
│   ├── extract/
│   ├── transform/
│   ├── import/
│   └── sql/
│
├── docs/
│
└── backups/
```

# Fases de migración

## Fase A

Inventario y análisis del sistema original.

## Fase B

Recuperación de la base de datos SQL Server.

## Fase C

Diseño del modelo de datos WordPress.

## Fase D

Construcción del proceso ETL.

## Fase E

Migración de taxonomías.

## Fase F

Migración de minerales.

## Fase G

Migración de ejemplares.

## Fase H

Migración de imágenes.

## Fase H.1

Asociación imágenes-minerales.

## Fase I

Relaciones mineral-ejemplar.

## Fase J

Relaciones documentales.

## Fase K

Relaciones mineral-mineral.

## Fase L

Relaciones fotografía-fotografía.

## Fase M

Desarrollo frontend y validaciones.

## Fase N

Buscador y validación final.

---

# Validación

Se realizaron validaciones de:

* Conteos de registros.
* Relaciones migradas.
* Integridad referencial.
* Imágenes.
* Navegación.
* Visualización frontend.

Todas las fases finalizaron satisfactoriamente.

---

# Operaciones habituales

## Regenerar relaciones

Ejecutar los importadores específicos del plugin.

## Reimportar imágenes

Lanzar nuevamente el importador de fotografías.

## Verificar integridad

Comprobar:

* Relaciones huérfanas.
* Imágenes inexistentes.
* Metadatos incompletos.

---

# Documentación complementaria

Consultar:

* Arquitectura_Origen_DSED.md
* Arquitectura_Destino_WordPress.md
* Modelo_Datos.md
* ETL.md
* Migracion_Fases_A_N.md
* Validacion.md
* Manual_Operacion.md

---

# Estado del proyecto

Migración completada.

Fases ejecutadas: A → N

Resultado:

Sistema SIC/DSED sustituido por plataforma WordPress moderna manteniendo la funcionalidad, los contenidos y las relaciones históricas del repositorio mineralógico.

Mi recomendación es guardarlo como:

```text
docs/README.md
```

y dejar la documentación completa de las fases en:

```text
docs/Migracion_Fases_A_N.md
```

de forma que el README actúe como punto de entrada para cualquier administrador o desarrollador futuro.
=======
Puedes usar este `README.md` como documento raíz del proyecto.

# Migración SIC/DSED Minerales a WordPress

## Descripción

Este proyecto tiene como objetivo la migración completa del sistema histórico SIC/DSED de gestión de minerales hacia una plataforma moderna basada en WordPress.

La migración conserva:

* Información mineralógica.
* Ejemplares de colección.
* Fotografías.
* Yacimientos.
* Museos.
* Enlaces documentales.
* Taxonomías y clasificaciones.
* Relaciones semánticas entre recursos.
* Modelo de navegación y búsqueda del SIC original.

El sistema original estaba basado en:

* ASP clásico.
* SQL Server.
* Repositorio documental externo.
* Aplicaciones DSEDSAU, DSEDCurso, DSEDWeb y SIC.

El sistema destino utiliza:

* WordPress.
* MariaDB.
* Docker.
* Plugin de migración personalizado.

---

# Objetivos

1. Modernizar la plataforma tecnológica.
2. Eliminar dependencias de ASP clásico.
3. Preservar la información histórica.
4. Mantener la estructura de relaciones existente.
5. Facilitar futuras ampliaciones.
6. Simplificar tareas de administración y mantenimiento.

---

# Arquitectura origen

## Componentes

### SQL Server

Almacenamiento de:

* Metadatos.
* Usuarios.
* Etiquetas.
* Relaciones.
* Configuración.

### Repositorio documental

Almacenamiento de:

* Imágenes.
* PDF.
* Documentos.
* Recursos asociados.

### SIC

Portal público de consulta.

### DSEDCurso

Gestión de contenidos.

### DSEDSAU

Administración de usuarios y grupos.

### DSEDWeb

Gestión avanzada de recursos.

---

# Arquitectura destino

## WordPress

Gestión de contenidos.

## MariaDB

Persistencia de datos.

## Plugin Migración DSED

Importadores.

Relaciones.

Componentes frontend.

## Mediateca WordPress

Almacenamiento de imágenes y recursos.

---

# Tipos de contenido migrados

## Mineral

Representa una especie mineral.

Campos principales:

* Nombre
* Fórmula
* Sistema cristalino
* Dureza
* Densidad
* Brillo
* Color

## Ejemplar

Representa una pieza concreta.

Campos principales:

* Código
* Procedencia
* Colección
* Ubicación

## Yacimiento

Información geológica de procedencia.

## Museo

Instituciones y colecciones.

## Recursos

Documentación complementaria.

---

# Relaciones migradas

## Mineral ↔ Mineral

Minerales relacionados.

## Mineral ↔ Ejemplar

Ejemplares asociados.

## Mineral ↔ Fotografía

Fotografías asociadas.

## Fotografía ↔ Fotografía

Imágenes relacionadas.

## Recurso ↔ Recurso

Documentación relacionada.

---

# Estructura del proyecto

```text
migracion_dsed/
│
├── docker/
│
├── wordpress/
│
├── plugin/
│   └── migracion_dsed/
│
├── minerales-etl/
│   ├── extract/
│   ├── transform/
│   ├── import/
│   └── sql/
│
├── docs/
│
└── backups/
```

# Fases de migración

## Fase A

Inventario y análisis del sistema original.

## Fase B

Recuperación de la base de datos SQL Server.

## Fase C

Diseño del modelo de datos WordPress.

## Fase D

Construcción del proceso ETL.

## Fase E

Migración de taxonomías.

## Fase F

Migración de minerales.

## Fase G

Migración de ejemplares.

## Fase H

Migración de imágenes.

## Fase H.1

Asociación imágenes-minerales.

## Fase I

Relaciones mineral-ejemplar.

## Fase J

Relaciones documentales.

## Fase K

Relaciones mineral-mineral.

## Fase L

Relaciones fotografía-fotografía.

## Fase M

Desarrollo frontend y validaciones.

## Fase N

Buscador y validación final.

---

# Validación

Se realizaron validaciones de:

* Conteos de registros.
* Relaciones migradas.
* Integridad referencial.
* Imágenes.
* Navegación.
* Visualización frontend.

Todas las fases finalizaron satisfactoriamente.

---

# Operaciones habituales

## Regenerar relaciones

Ejecutar los importadores específicos del plugin.

## Reimportar imágenes

Lanzar nuevamente el importador de fotografías.

## Verificar integridad

Comprobar:

* Relaciones huérfanas.
* Imágenes inexistentes.
* Metadatos incompletos.

---

# Documentación complementaria

Consultar:

* Arquitectura_Origen_DSED.md
* Arquitectura_Destino_WordPress.md
* Modelo_Datos.md
* ETL.md
* Migracion_Fases_A_N.md
* Validacion.md
* Manual_Operacion.md

---

# Estado del proyecto

Migración completada.

Fases ejecutadas: A → N

Resultado:

Sistema SIC/DSED sustituido por plataforma WordPress moderna manteniendo la funcionalidad, los contenidos y las relaciones históricas del repositorio mineralógico.

Después de haber completado la migración, mi valoración es que **sí merece la pena**, pero **no como sustitución del modelo WordPress actual**, sino como una **capa de trazabilidad y gobierno del dato**.

Actualmente la migración se apoya en tres identificadores:

```text
legacy_id     → ID en SIC/DSED
post_id       → ID WordPress
meta_key      → ubicación del dato
```

Esto ha funcionado bien para migrar, pero presenta limitaciones para futuras evoluciones.

---

# Situación actual

Por ejemplo, Calcita:

```text
legacy_id = 61
post_id   = 66
```

y tiene asociados:

```text
35 fotografías
39 ejemplares
36 recursos
2 enlaces
1 mineral relacionado
```

Todo ello se relaciona mediante:

```text
wp_posts
wp_postmeta
```

El problema es que WordPress identifica:

```text
Mineral
Fotografía
Ejemplar
Recurso
```

como entidades independientes, pero no identifica cada dato individual.

Por ejemplo:

```text
Calcita
 ├─ Fórmula
 ├─ Dureza
 ├─ Aplicación
 ├─ Etimología
 ├─ Fotografía 1
 ├─ Fotografía 2
 └─ ...
```

No existe un identificador universal para cada uno de esos elementos.

---

# Propuesta

Crear una tabla transversal:

```sql
CREATE TABLE dsed_uid (
    uid CHAR(36) PRIMARY KEY,
    entity_type VARCHAR(50),
    wp_post_id BIGINT,
    legacy_id BIGINT,
    source_table VARCHAR(100),
    source_pk BIGINT,
    created_at DATETIME
);
```

Ejemplo:

```text
UID                                  Tipo
--------------------------------------------------
4b3e...                              Mineral
9c7a...                              Fotografía
11aa...                              Ejemplar
7f9d...                              Recurso
```

---

# Propuesta más potente

Ir un paso más allá.

## Tabla de entidades

```sql
dsed_entity
```

```text
UID
Tipo
Nombre
Origen
Legacy_ID
WP_ID
```

Ejemplo:

```text
UID=A001
Tipo=MINERAL
Nombre=CALCITA

UID=A002
Tipo=FOTO
Nombre=Calcita_Asturias_01
```

---

## Tabla de relaciones

```sql
dsed_relation
```

```text
UID_ORIGEN
UID_DESTINO
TIPO_RELACION
```

Ejemplo:

```text
A001 → A002 FOTO_RELACIONADA
A001 → A100 EJEMPLAR_RELACIONADO
A001 → A300 RECURSO_RELACIONADO
```

---

# Ventajas

## 1. Independencia de WordPress

Si dentro de 10 años migras a:

* Drupal
* Django
* Headless CMS
* GraphDB
* Neo4j

mantienes:

```text
UID = estable
```

aunque cambien todos los IDs internos.

---

## 2. Auditoría perfecta

Podrías responder:

```text
¿De dónde salió esta fotografía?
```

o

```text
¿Qué elementos proceden del recurso SIC 726?
```

instantáneamente.

---

## 3. Trazabilidad histórica

Ejemplo:

```text
Calcita
UID = MIN-000061
Legacy_ID = 61
WP_ID = 66
```

Nunca pierdes la referencia original.

---

## 4. Integración IA

Es probablemente la ventaja más interesante.

Con una tabla de entidades:

```text
MINERAL
EJEMPLAR
FOTO
RECURSO
MUSEO
YACIMIENTO
```

y otra de relaciones:

```text
RELACIONADO_CON
FOTO_DE
PROCEDE_DE
ENLAZA_A
```

obtienes un grafo de conocimiento mineralógico.

Después podrías consultar:

```text
Muéstrame todos los minerales relacionados con la calcita
que tengan fotografías de Asturias
y ejemplares en museos.
```

sin depender de WordPress.

---

# Mi valoración

## Para la migración realizada

```text
No necesario
```

La migración ya está terminada y validada.

---

## Para preservación digital a largo plazo

```text
Muy recomendable
```

---

## Para un DSED 3.0

```text
Altamente recomendable
```

Yo lo implementaría como:

```text
Fase O
  dsed_entity
  dsed_relation
  UID global

Fase P
  API semántica

Fase Q
  Grafo de conocimiento mineralógico
```

porque convertiría el resultado de la migración en algo más valioso que un WordPress: un modelo de conocimiento independiente de cualquier plataforma futura.
