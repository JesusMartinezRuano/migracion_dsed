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

Mi recomendación es guardarlo como:

```text
docs/README.md
```

y dejar la documentación completa de las fases en:

```text
docs/Migracion_Fases_A_N.md
```

de forma que el README actúe como punto de entrada para cualquier administrador o desarrollador futuro.
