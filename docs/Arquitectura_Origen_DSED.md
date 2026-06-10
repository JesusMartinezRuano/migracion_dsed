# Arquitectura Origen DSED/SIC

## Introducción

El sistema original DSED (Dynamic Systems for E-Document) es una plataforma de gestión del conocimiento desarrollada para almacenar, clasificar, organizar, relacionar y publicar información especializada.

La arquitectura fue diseñada siguiendo los principios del método CSORA:

* Classify
* Search
* Organize
* Relate
* Adapt

Su objetivo era permitir la gestión flexible de contenidos, independientemente de su estructura, facilitando la reutilización del conocimiento y su publicación mediante distintos interfaces.

---

# Visión General

El ecosistema original estaba formado por varios componentes independientes que compartían una base de datos común y un repositorio documental.

```text
+------------------+
|     DSEDSAU      |
+------------------+
          |
          |
+------------------+
|    SQL Server    |
+------------------+
          |
          |
+------------------+
|  Repositorio     |
|  Documental      |
+------------------+
     /      \
    /        \
+--------+ +--------+
|DSEDWEB | |DSEDCURSO|
+--------+ +--------+
     \        /
      \      /
     +--------+
     |  SIC   |
     +--------+
```

---

# Componentes Principales

## DSEDSAU

Aplicación encargada de la administración general del sistema.

Funciones:

* Gestión de usuarios.
* Gestión de grupos.
* Gestión de permisos.
* Gestión de perfiles.
* Configuración global.
* Administración de etiquetas.

Responsabilidades:

* Alta de usuarios.
* Baja de usuarios.
* Asignación de grupos.
* Gestión masiva de etiquetas.

---

## DSEDCurso

Aplicación principal de gestión de contenidos.

Funciones:

* Creación de recursos.
* Modificación de recursos.
* Organización de recursos.
* Gestión de etiquetas.
* Gestión de índices.
* Gestión documental.

Tipos de recursos habituales:

* Minerales.
* Fotografías.
* Museos.
* Yacimientos.
* Enlaces web.
* Documentación.
* Crónicas.

---

## DSEDWeb

Aplicación de gestión avanzada.

Permitía:

* Navegación de recursos.
* Organización documental.
* Gestión complementaria de contenidos.
* Acceso a repositorios.

Su uso era menor que DSEDCurso.

---

## SIC

Portal público de publicación.

Objetivos:

* Presentación de contenidos.
* Navegación temática.
* Consulta pública.
* Difusión de conocimiento.

El SIC consumía información almacenada en grupos DSED.

Cada SIC se configuraba mediante:

* Grupo asociado.
* Árbol principal.
* Etiquetas centrales.
* Etiquetas laterales.
* Plantillas visuales.

---

# Arquitectura Técnica

## Servidor Web

Tecnología:

* Microsoft IIS 5.0 o superior.

Lenguaje:

* ASP Clásico.

Archivos principales:

```text
inicio.asp
principal.asp
buscar.asp
ficha.asp
```

---

## Base de Datos

Motor:

```text
Microsoft SQL Server 2000 SP4
```

Responsabilidades:

* Metadatos.
* Usuarios.
* Relaciones.
* Etiquetas.
* Índices.
* Configuración.

---

## Repositorio Documental

Almacenamiento físico independiente.

Contenido:

* Imágenes.
* PDFs.
* Documentos Office.
* Recursos multimedia.

Ejemplo:

```text
RepoMinerales/
├── Mineral00001.jpg
├── Mineral00002.jpg
├── Mineral00003.jpg
└── ...
```

La base de datos almacenaba referencias a los ficheros, pero no los binarios.

---

# Modelo Conceptual

El sistema se basaba en una separación clara entre:

## Metadatos

Información estructurada almacenada en SQL Server.

Ejemplos:

* Nombre mineral.
* Fórmula química.
* Procedencia.
* Etiquetas.
* Relaciones.

---

## Recursos

Información física almacenada en el repositorio.

Ejemplos:

* Fotografías.
* PDFs.
* Artículos.
* Imágenes.

---

# Sistema de Etiquetas

Las etiquetas constituían uno de los pilares fundamentales del sistema.

Permitían:

* Clasificación.
* Búsqueda.
* Relación.
* Navegación.

Existían:

## Etiquetas de búsqueda

Utilizadas por el buscador.

## Etiquetas de organización

Utilizadas para agrupar resultados.

## Etiquetas de relación

Utilizadas para conectar recursos relacionados.

---

# Sistema de Índices

Los índices eran estructuras jerárquicas tipo árbol.

Permitían:

* Organizar contenidos.
* Crear menús.
* Construir navegadores temáticos.

Ejemplo:

```text
Minerales
├── Silicatos
│   ├── Cuarzo
│   └── Feldespatos
├── Sulfuros
│   ├── Pirita
│   └── Galena
└── Carbonatos
    └── Calcita
```

---

# Modelo de Relaciones

El sistema permitía relacionar recursos arbitrariamente.

Ejemplos:

## Mineral ↔ Mineral

Minerales asociados.

## Mineral ↔ Fotografía

Fotografías ilustrativas.

## Mineral ↔ Ejemplar

Piezas de colección.

## Recurso ↔ Recurso

Documentación relacionada.

---

# Sistema de Búsqueda

Basado en el método CSORA.

Permitía:

* Filtrado por etiquetas.
* Filtrado por categorías.
* Navegación temática.
* Relación automática de contenidos.

---

# Limitaciones Detectadas

Durante el análisis previo a la migración se identificaron:

## Tecnológicas

* ASP clásico obsoleto.
* Dependencia de IIS.
* Dependencia de SQL Server 2000.

## Mantenimiento

* Código difícil de extender.
* Escasa documentación técnica.
* Dependencia de configuraciones manuales.

## Integración

* APIs inexistentes.
* Dificultad para integración con sistemas modernos.

## Seguridad

* Componentes sin soporte.
* Dependencias fuera de ciclo de vida.

---

# Motivación de la Migración

La migración a WordPress perseguía:

* Modernización tecnológica.
* Eliminación de dependencias heredadas.
* Conservación del conocimiento histórico.
* Mejora de mantenibilidad.
* Mejora de seguridad.
* Facilitar futuras ampliaciones.

---

# Resumen

La arquitectura DSED/SIC fue una solución avanzada para su época basada en:

* SQL Server.
* ASP clásico.
* Repositorio documental externo.
* Gestión flexible mediante etiquetas.
* Relaciones semánticas entre contenidos.
* Publicación mediante portales SIC.

La migración realizada preserva estos conceptos fundamentales trasladándolos a una arquitectura moderna basada en WordPress, MariaDB y componentes estándar de código abierto.
