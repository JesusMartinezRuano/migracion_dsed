# Manual de Operación

## Introducción

Este documento describe los procedimientos operativos necesarios para administrar y mantener la plataforma resultante de la migración del sistema SIC/DSED a WordPress.

Está dirigido a:

* Administradores del sistema.
* Técnicos de soporte.
* Responsables del repositorio mineralógico.
* Desarrolladores de mantenimiento.

---

# Alcance

El manual cubre:

* Arranque del sistema.
* Parada del sistema.
* Copias de seguridad.
* Restauración.
* Gestión de contenidos.
* Gestión de imágenes.
* Verificación de relaciones.
* Resolución de incidencias.
* Actualizaciones.

---

# Arquitectura Operativa

## Componentes

```text
WordPress
MariaDB
Docker
Plugin migracion_dsed
Repositorio Multimedia
```

---

# Acceso al Servidor

## Conexión SSH

```bash
ssh deadmin@SERVIDOR
```

---

## Verificar estado

```bash
docker ps
```

Resultado esperado:

```text
wordpress
db
```

---

# Arranque del Sistema

Situarse en el directorio:

```bash
cd /opt/migracion_dsed
```

Arrancar servicios:

```bash
docker compose up -d
```

Verificar:

```bash
docker ps
```

---

# Parada del Sistema

Parada controlada:

```bash
docker compose down
```

---

# Reinicio del Sistema

```bash
docker compose restart
```

---

# Acceso a WordPress

## Administración

```text
http://SERVIDOR/wp-admin
```

Acceder con un usuario administrador.

---

# Gestión de Contenidos

Los contenidos se gestionan mediante:

## Minerales

```text
Minerales
→ Todos los minerales
```

Permite:

* Crear.
* Editar.
* Eliminar.

---

## Ejemplares

```text
Ejemplares
→ Todos los ejemplares
```

---

## Yacimientos

```text
Yacimientos
→ Todos los yacimientos
```

---

## Museos

```text
Museos
→ Todos los museos
```

---

# Gestión de Imágenes

Las imágenes se almacenan en:

```text
WordPress
→ Medios
```

---

## Verificar imágenes

Comprobar:

* Imagen visible.
* Miniaturas generadas.
* Asociación correcta.

---

## Regenerar miniaturas

Si fuera necesario:

```bash
wp media regenerate
```

---

# Gestión de Relaciones

Las relaciones son gestionadas por el plugin:

```text
migracion_dsed
```

---

## Tipos de relación

### Mineral ↔ Mineral

Meta:

```text
mineral_relacionado
```

---

### Mineral ↔ Ejemplar

Meta:

```text
ejemplar_relacionado
```

---

### Mineral ↔ Fotografía

Meta:

```text
foto_relacionada
```

---

### Recurso ↔ Recurso

Meta:

```text
recurso_relacionado
```

---

# Validación de Relaciones

## Consultar relaciones

Acceder a una ficha mineral.

Comprobar:

* Ejemplares asociados.
* Fotografías asociadas.
* Minerales relacionados.

---

## Detectar relaciones huérfanas

Ejemplo SQL:

```sql
SELECT *
FROM wp_postmeta pm
LEFT JOIN wp_posts p
ON p.ID = pm.meta_value
WHERE pm.meta_key='mineral_relacionado'
AND p.ID IS NULL;
```

Resultado esperado:

```text
0 registros
```

---

# Copias de Seguridad

## Base de Datos

Exportación:

```bash
docker exec migracion_dsed_db \
mysqldump \
-u root \
-pPASSWORD \
migracion_dsed \
> backup.sql
```

---

## WordPress

Copiar:

```bash
wp-content/uploads
wp-content/plugins/migracion_dsed
```

---

## Backup completo

```bash
tar czf backup_completo.tar.gz \
wordpress \
uploads \
backup.sql
```

---

# Restauración

## Base de Datos

```bash
docker exec -i migracion_dsed_db \
mariadb \
-u root \
-pPASSWORD \
migracion_dsed \
< backup.sql
```

---

## Archivos

Restaurar:

```bash
wp-content/uploads
wp-content/plugins/migracion_dsed
```

---

# Consultas de Verificación

## Número de minerales

```sql
SELECT COUNT(*)
FROM wp_posts
WHERE post_type='mineral';
```

---

## Número de ejemplares

```sql
SELECT COUNT(*)
FROM wp_posts
WHERE post_type='ejemplar';
```

---

## Número de imágenes

```sql
SELECT COUNT(*)
FROM wp_posts
WHERE post_type='attachment';
```

---

# Logs

## WordPress

```text
wp-content/debug.log
```

---

## Docker

```bash
docker logs wordpress
docker logs migracion_dsed_db
```

---

# Problemas Frecuentes

## Imagen no visible

### Comprobar

```text
Medios
```

### Verificar

```text
_wp_attached_file
```

### Solución

Reimportar imagen.

---

## Relación inexistente

### Verificar

```text
legacy_id
```

### Reejecutar importador correspondiente.

---

## Página en blanco

### Comprobar

```bash
docker logs wordpress
```

### Revisar

```text
wp-content/debug.log
```

---

# Reejecución de Importadores

El plugin dispone de importadores específicos.

Ejemplos:

```text
?import_minerales=1
```

```text
?import_ejemplares=1
```

```text
?import_rel_mineral_ejemplar=1
```

```text
?import_rel_mineral_enlace=1
```

```text
?import_rel_fotos=1
```

---

# Actualización de WordPress

## Actualizar núcleo

```bash
wp core update
```

---

## Actualizar plugins

```bash
wp plugin update --all
```

---

## Actualizar temas

```bash
wp theme update --all
```

---

# Comprobaciones Posteriores a una Actualización

Verificar:

* Acceso al panel.
* Visualización de minerales.
* Visualización de ejemplares.
* Relaciones.
* Buscador.
* Imágenes.

---

# Monitorización Recomendada

Revisar periódicamente:

## Espacio en disco

```bash
df -h
```

---

## Estado Docker

```bash
docker ps
```

---

## Tamaño Base de Datos

```sql
SHOW TABLE STATUS;
```

---

# Procedimiento de Recuperación ante Desastre

## Escenario

Pérdida total del servidor.

---

## Pasos

1. Instalar Docker.
2. Restaurar proyecto.
3. Restaurar WordPress.
4. Restaurar uploads.
5. Restaurar base de datos.
6. Arrancar contenedores.
7. Ejecutar validaciones.

---

# Checklist Operativo Mensual

## Sistema

* [ ] Docker operativo.
* [ ] WordPress accesible.
* [ ] MariaDB accesible.

## Datos

* [ ] Conteos correctos.
* [ ] Imágenes visibles.
* [ ] Relaciones operativas.

## Seguridad

* [ ] Copias de seguridad verificadas.
* [ ] Actualizaciones aplicadas.
* [ ] Logs revisados.

---

# Conclusión

La plataforma resultante está diseñada para minimizar las tareas de mantenimiento y facilitar futuras ampliaciones.

Las operaciones habituales se reducen a:

* Gestión de contenidos.
* Supervisión de copias de seguridad.
* Actualizaciones periódicas.
* Verificación ocasional de relaciones e imágenes.

Siguiendo los procedimientos descritos en este manual, el sistema puede mantenerse operando de forma estable y segura a largo plazo.
