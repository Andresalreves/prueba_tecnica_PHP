# prueba_tecnica_PHP
Prueba tecnica en php puro 

#############################################################
Gestión de Productos y Asignación a Grupos
Objetivo y Contexto
Desarrolla una aplicación web en PHP nativo (usando OOP) que permita administrar productos y su asignación a grupos. La solución debe seguir un patrón MVC básico y utilizar AJAX para realizar las operaciones CRUD sin recargar la página. Se evaluará la organización del código, el uso correcto de OOP, buenas prácticas (como el uso de PDO y prepared statements) y la correcta estructuración de la base de datos.

Requerimientos
1. Base de Datos
Tabla productos:
Crear una tabla con al menos 7 campos, por ejemplo:
id 
nombre 
descripcion 
precio 
stock 
fecha_creacion 
estado (TINYINT o ENUM para activo/inactivo)
Tabla grupos:
Crear una tabla para almacenar grupos, con campos como:
id 
nombre
descripcion 
Tabla Intermedia producto_grupo:
Gestionar la relación muchos a muchos entre productos y grupos:
producto_id (INT, FOREIGN KEY a productos.id)
grupo_id (INT, FOREIGN KEY a grupos.id)
(Definir índice compuesto para optimizar las consultas)
2. Funcionalidad
CRUD para Productos:
Crear: Insertar nuevos productos validando los datos (por ejemplo, que el nombre no esté vacío y el precio sea numérico).
Leer: Listar productos (opcionalmente con paginación o filtros sencillos).
Actualizar: Editar la información de un producto existente.
Eliminar: Borrar un producto (con confirmación previa).
CRUD para Grupos:
Permitir crear, leer, actualizar y eliminar grupos.
Asignación de Productos a Grupos:
Permitir asignar y remover productos a/de grupos.
Mostrar los productos asignados a cada grupo y facilitar su edición.
3. Consideraciones Técnicas
Arquitectura y Organización:
Aplica un patrón MVC básico separando la lógica. 
Comunicación AJAX:
Todas las operaciones (crear, leer, actualizar, eliminar y asignar) se deben realizar mediante AJAX para evitar la recarga completa de la página.
Seguridad y Buenas Prácticas:
Realiza validación y sanitización de los datos tanto en el cliente (JavaScript) como en el servidor.

Criterios de Evaluación
Diseño y Estructura:
Correcta separación en MVC, modularidad del código y organización en carpetas.
Implementación Técnica:
Uso de PHP nativo y programación orientada a objetos.
Diseño adecuado de la base de datos (índices, claves primarias y foráneas).
Implementación de operaciones CRUD y asignación mediante AJAX.
Calidad del Código:
Legibilidad, buenas prácticas (validación de datos) y comentarios.
Experiencia de Usuario:
Interfaz sencilla que permita realizar las operaciones sin recarga de página y notificar al usuario sobre el resultado de cada acción.



