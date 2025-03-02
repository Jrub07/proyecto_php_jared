# Proyecto PHP Jared

Este proyecto es una aplicación web llamada "Badulake" que permite a los usuarios registrarse, iniciar sesión y gestionar sus datos. La aplicación está construida utilizando PHP y MySQL.

## Estructura del Proyecto

- **index.php**: Página principal de la aplicación donde los usuarios pueden iniciar sesión o registrarse.
- **controllers/UsuarioController.php**: Controlador que maneja las solicitudes relacionadas con los usuarios, como iniciar sesión, registrarse, modificar datos, etc.
- **controllers/CategoriaController.php**: Controlador que maneja las solicitudes relacionadas con las categorías, como ver, crear, modificar y eliminar categorías.
- **controllers/ProductoController.php**: Controlador que maneja las solicitudes relacionadas con los productos, como ver, crear, modificar y eliminar productos.
- **vistas/**: Carpeta que contiene las vistas de la aplicación, como formularios y páginas de usuario.
- **styles/**: Carpeta que contiene los archivos CSS para el estilo de la aplicación.
- **img/**: Carpeta que contiene las imágenes utilizadas en la aplicación.

## Uso

### Página Principal

La página principal (`index.php`) permite a los usuarios iniciar sesión o registrarse. Dependiendo de la acción seleccionada, el formulario enviará los datos al controlador correspondiente.

### Controlador de Usuario

El archivo `controllers/UsuarioController.php` maneja las siguientes acciones:

- **manejarSolicitud()**: Maneja las solicitudes HTTP entrantes y dirige la solicitud a la función correspondiente.
- **cargar_usuario($user_id)**: Carga los datos de un usuario específico desde la base de datos y los muestra en un formulario para su modificación.
- **usuario_modifica_datos()**: Carga los datos del usuario actual desde la base de datos y los muestra en un formulario para que el usuario pueda modificar sus propios datos.
- **actualizar_datos()**: Actualiza los datos personales del usuario actual en la base de datos.
- **guardar_usuario()**: Actualiza los datos de un usuario específico en la base de datos.
- **iniciarSesion()**: Verifica las credenciales del usuario y lo redirige a la página correspondiente según su rol.
- **registrarse()**: Registra un nuevo usuario en la base de datos.
- **logout()**: Cierra la sesión del usuario actual y redirige al usuario a la página principal.
- **ver_usuarios()**: Muestra una lista de todos los usuarios registrados en la base de datos.
- **modificar_usuario()**: Redirige a la página de modificación de usuario con el ID del usuario que se desea modificar.
- **actualizar_usuario()**: Actualiza los datos de un usuario específico en la base de datos.
- **eliminar_usuario()**: Elimina un usuario específico de la base de datos.

### Controlador de Categorías

El archivo `controllers/CategoriaController.php` maneja las siguientes acciones:

- **manejarSolicitud()**: Maneja las solicitudes HTTP entrantes y dirige la solicitud a la función correspondiente.
- **ver_categorias()**: Muestra una lista de todas las categorías registradas en la base de datos.
- **crear_categoria()**: Crea una nueva categoría en la base de datos.
- **mostrar_formulario_modificar()**: Carga los datos de una categoría específica desde la base de datos y los muestra en un formulario para su modificación.
- **actualizar_categoria()**: Actualiza los datos de una categoría específica en la base de datos.
- **eliminar_categoria($id)**: Elimina una categoría específica de la base de datos.
- **ver_crear_productos()**: Método placeholder para ver y crear productos (a implementar).
- **obtenerCategorias()**: Obtiene una lista de categorías desde la base de datos y las devuelve como un array asociativo.

### Controlador de Productos

El archivo `controllers/ProductoController.php` maneja las siguientes acciones:

- **manejarSolicitud()**: Maneja las solicitudes HTTP entrantes y dirige la solicitud a la función correspondiente.
- **ver_productos()**: Muestra una lista de todos los productos registrados en la base de datos.
- **crear_producto()**: Crea un nuevo producto en la base de datos.
- **mostrar_formulario_modificar()**: Carga los datos de un producto específico desde la base de datos y los muestra en un formulario para su modificación.
- **actualizar_producto()**: Actualiza los datos de un producto específico en la base de datos.
- **eliminar_producto($id)**: Elimina un producto específico de la base de datos.
- **obtenerProductos()**: Obtiene una lista de productos desde la base de datos y los devuelve como un array asociativo.
- **obtenerProductosPorCategoria($categoria_id)**: Obtiene una lista de productos de una categoría específica desde la base de datos y los devuelve como un array asociativo.

### Vistas

Las vistas se encuentran en la carpeta `vistas/` y se utilizan para mostrar formularios y páginas de usuario. Algunas de las vistas incluidas son:

- **formulario_registro.php**: Formulario para registrar un nuevo usuario.
- **usuario_modifica_datos.php**: Formulario para que los usuarios modifiquen sus datos.
- **ver_usu.php**: Página que muestra una lista de usuarios (solo para administradores).
- **menu_tienda_admin.php**: Página principal para administradores.
- **menu_tienda_usu.php**: Página principal para usuarios.
- **modificar_usu.php**: Formulario para modificar los datos de un usuario.
- **ver_categorias.php**: Página que muestra una lista de categorías.
- **modificar_categorias_admin.php**: Formulario para modificar los datos de una categoría.
- **ver_productos.php**: Página que muestra una lista de productos.
- **modificar_producto_admin.php**: Formulario para modificar los datos de un producto.

