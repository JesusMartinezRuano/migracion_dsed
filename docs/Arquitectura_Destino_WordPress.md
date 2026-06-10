# Arquitectura Destino WordPress

## Introducción

Este documento describe la arquitectura final resultante de la migración del sistema histórico SIC/DSED al nuevo entorno basado en WordPress.

El objetivo principal de la migración ha sido conservar el conocimiento acumulado durante años en el sistema DSED, modernizando simultáneamente la infraestructura tecnológica para facilitar el mantenimiento, la escalabilidad y la evolución futura del proyecto.

La nueva arquitectura sustituye completamente:

* ASP Clásico
* IIS
* SQL Server 2000
* Configuraciones XML SIC

por tecnologías modernas de código abierto.

---

# Objetivos de la Arquitectura

La nueva plataforma debía cumplir los siguientes requisitos:

* Preservar todos los contenidos históricos.
* Mantener las relaciones existentes.
* Facilitar nuevas ampliaciones.
* Simplificar tareas de administración.
* Permitir despliegues reproducibles.
* Reducir dependencias tecnológicas obsoletas.
* Mejorar seguridad y mantenibilidad.

---

# Arquitectura General

```text
┌──────────────────────────────┐
│          Usuario             │
└──────────────┬───────────────┘
               │
               ▼
┌──────────────────────────────┐
│          WordPress           │
│                              │
│  CPT + Taxonomías + Theme    │
└──────────────┬───────────────┘
               │
               ▼
┌──────────────────────────────┐
│     Plugin migracion_dsed    │
└──────────────┬───────────────┘
               │
               ▼
┌──────────────────────────────┐
│          MariaDB             │
└──────────────┬───────────────┘
               │
               ▼
┌──────────────────────────────┐
│   Biblioteca Multimedia      │
│         WordPress            │
└──────────────────────────────┘
```

---

# Componentes Principales

## WordPress

WordPress constituye el núcleo funcional de la solución.

Responsabilidades:

* Gestión de contenidos.
* Gestión de usuarios.
* Gestión multimedia.
* Gestión de taxonomías.
* Publicación web.
* APIs REST.

Ventajas:

* Amplio soporte.
* Comunidad activa.
* Actualizaciones continuas.
* Ecosistema de extensiones.

---

## MariaDB

Motor de persistencia principal.

Responsabilidades:

* Almacenamiento de contenidos.
* Relaciones.
* Taxonomías.
* Configuración WordPress.

Sustituye completamente a SQL Server.

---

## Plugin Migración DSED

Plugin desarrollado específicamente para el proyecto.

Nombre:

```text
migracion_dsed
```

Responsabilidades:

* Importación de datos históricos.
* Gestión de relaciones.
* Renderizado de relaciones.
* Procesos de validación.
* Herramientas administrativas.

---

# Modelo de Contenidos

La información se organiza mediante Custom Post Types (CPT).

---

## Mineral

Representa una especie mineral.

Campos principales:

* Nombre.
* Fórmula química.
* Sistema cristalino.
* Dureza.
* Densidad.
* Color.
* Brillo.
* Raya.

---

## Ejemplar

Representa una pieza física.

Campos principales:

* Código.
* Procedencia.
* Colección.
* Ubicación.
* Observaciones.

---

## Yacimiento

Representa una localización geológica.

Campos principales:

* Nombre.
* Municipio.
* Provincia.
* Comunidad Autónoma.
* País.

---

## Museo

Representa instituciones y colecciones.

Campos principales:

* Nombre.
* Ubicación.
* Descripción.

---

## Recursos

Documentación auxiliar.

Ejemplos:

* Artículos.
* Enlaces.
* Documentos PDF.
* Referencias bibliográficas.

---

# Gestión Multimedia

Las imágenes históricas fueron migradas a la Biblioteca Multimedia de WordPress.

Características:

* Gestión centralizada.
* Miniaturas automáticas.
* Optimización de imágenes.
* Compatibilidad con WordPress.

Cada imagen queda registrada como:

```text
attachment
```

dentro de:

```text
wp_posts
```

---

# Sistema de Relaciones

Uno de los objetivos principales fue conservar la semántica existente en DSED.

---

## Mineral ↔ Mineral

Minerales relacionados.

Ejemplos:

* Variedades.
* Asociaciones mineralógicas.
* Grupos minerales.

---

## Mineral ↔ Ejemplar

Asocia especies minerales con piezas de colección.

---

## Mineral ↔ Fotografía

Permite mostrar galerías asociadas.

---

## Fotografía ↔ Fotografía

Permite construir conjuntos documentales.

---

## Recurso ↔ Recurso

Documentación relacionada.

---

# Taxonomías

Se han migrado las etiquetas históricas del sistema DSED.

Utilización:

* Clasificación.
* Filtrado.
* Búsqueda.
* Navegación.

Tipos:

## Etiquetas

Etiquetas temáticas.

## Clasificaciones

Agrupaciones funcionales.

---

# Buscador

El sistema incorpora un buscador orientado a la filosofía original CSORA.

Permite:

* Buscar.
* Clasificar.
* Organizar.
* Relacionar.
* Adaptar.

Filtros disponibles:

* Mineral.
* Procedencia.
* Provincia.
* Museo.
* Colección.
* Etiquetas.

---

# Frontend de Relaciones

El plugin incorpora componentes específicos para visualizar relaciones.

Componentes:

```text
dsed-grid-relaciones
dsed-card-relacion
```

Características:

* Responsive.
* Miniaturas.
* Navegación cruzada.
* Relación bidireccional.

---

# Arquitectura Física

## Contenedores

La solución se despliega mediante Docker.

Servicios principales:

### WordPress

Servidor web y aplicación.

### MariaDB

Persistencia de datos.

### Volúmenes

Persistencia de:

* uploads
* base de datos
* configuraciones

---

# Flujo de Datos

## Migración Inicial

```text
SQL Server (.bak)
        │
        ▼
   Extracción ETL
        │
        ▼
      CSV
        │
        ▼
 Plugin migracion_dsed
        │
        ▼
    WordPress
```

---

## Operación Normal

```text
Usuario
   │
   ▼
WordPress
   │
   ▼
Plugin DSED
   │
   ▼
MariaDB
```

---

# Seguridad

La arquitectura actual mejora significativamente respecto al sistema original.

Mejoras:

* Actualizaciones periódicas.
* Control de roles WordPress.
* Copias de seguridad automatizadas.
* Eliminación de dependencias obsoletas.
* Compatibilidad con HTTPS.

---

# Mantenimiento

Las tareas habituales son:

## Actualización WordPress

Actualización del núcleo.

## Actualización Plugins

Actualización de componentes.

## Copias de Seguridad

Base de datos.

Directorio uploads.

Plugin migracion_dsed.

## Monitorización

Logs WordPress.

Logs Docker.

Logs MariaDB.

---

# Escalabilidad

La arquitectura permite futuras ampliaciones:

* Nuevos CPT.
* Nuevas taxonomías.
* Nuevos importadores.
* Nuevas relaciones.
* APIs externas.
* Integración con sistemas GIS.
* Integración con repositorios científicos.

---

# Resultado Final

La nueva arquitectura sustituye completamente el sistema SIC/DSED manteniendo:

* Contenidos históricos.
* Relaciones semánticas.
* Estructura documental.
* Funcionalidad de búsqueda.
* Navegación temática.

La solución final proporciona una plataforma moderna, mantenible y escalable basada en WordPress, preparada para futuras evoluciones del proyecto mineralógico.

Este documento encaja como:

```text
docs/Arquitectura_Destino_WordPress.md
```

y junto con `Arquitectura_Origen_DSED.md` proporciona la visión completa del antes y después de la migración.
