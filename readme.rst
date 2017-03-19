###################
Explicación del proceso de la aplicación
###################

Esta aplicación se ha realizado para GMK Medialab a modo de Test por Gerard Martínez Soy.

*******************
Funcionamiento general de la aplicación
*******************

Esta aplicación realiza el procedimiento de Creación, Actualización, Lectura y Borrado de Usuarios en un entorno
PHP con Codeigniter.

He añadido Bootstrap y Jquery a la aplicación para poder dar un estilo agradable.
Jquery además, se ha usado para procesar algunos procesos de validación de forma asíncrona y validar algunos datos
de los formularios, así como añadir algunos mensajes de información para el usuario.

La aplicación se basa en el uso de un usuario activo, un usuario de la base de datos que se almacena en la sesión del
usuario y que se utiliza para gestionar el resto de acciones.
-Si el usuario activo tiene permiso de lectura en la columna de la derecha de la aplicación podrá ver un listado de los usuarios
existentes en la base de datos.
-Si el usuario activo tiene permiso de creación de usuarios, aparecerá un botón de creación que habilitará un formulario con 
el que se podrán rellenar datos para insertar un nuevo usuario con diferentes roles dentro de la base de datos.
-Si el usuario activo tiene permiso para actualizar otros usuarios, en el listado de usuarios aparecerá un botón que permite habilitar
un formulario que servirá para editar ese usuario.
-Si el usuario activo tiene permiso para borrar otros usuarios, en el listado de usuarios aparecerá un botón que permite borrar dicho usuario.

Los diferentes formularios validan por jquery que el campo de nombre y el campo de email estén cumplimentados.
Al enviar tanto un formulario de creación como de edición o una solicitud de borrado por AJAX, en php validamos que los campos necesarios estén rellenados,
aparte de comprobar también que el usuario tenga realmente el permiso de la acción que se va a realizar.
Una vez se recibe una respuesta positiva o errónea en AJAX, enseñamos un mensaje de información al usuario y refrescamos la aplicación al cabo de 3 segundos
en caso de que sea necesario actualizar los datos de los usuarios que aparecen en pantalla.

**************************
Estructura de la base de datos
**************************

La base de datos consiste en 3 sencillas tablas (users, roles, user_role):
-La tabla users contiene la información relevante al usuario, esta es: el nombre, el email, el teléfono y la edad.
-La tabla roles contiene la información relevante a los diferentes roles, estos son: el nombre del rol, permiso de lectura, permiso de creación, permiso de actualización y permiso de borrado.
-La tabla user_role contiene los identificativos tanto de users como roles para mantener una relación con información sobre los roles que tiene cada usuario.

**************************
Mejoras y opiniones personales sobre la estructura de la aplicación
**************************

Este proyecto se ha realizado a modo de Test, así que considero que el código no es apto para ser usado en un entorno de producción,
tendría que ser adaptado y revisado encarecidamente para minimizar la posibilidad de errores o fallos.
La aplicación podría tendría que ser mejorada en cuanto a la seguridad se refiere, habría que revisar los procesos de validación y ver que mejoras se pueden implementar
para asegurar un buen funcionamiento y que la base de datos no puede ser modificada por personas malintencionadas.

Es bastante probable que muchos procesos puedan ser reescritos de una forma más optima, así que sería conveniente
revisar el codigo para mejorar su eficiencia.

También la distribución del código podria ser más estructurada, quizá usar distintos controladores o modelos diferentes para usuarios y roles, para conseguir
de esta forma un diseño más modular y sencillo de mantener.

**************************
Otras consideraciones
**************************

En esta aplicación la creación de roles y mantenimiento de estos mismos no está implementada.
No obstante se pueden añadir nuevos roles o alterar los existentes con total libertad. La aplicación los reconocerá correctamente.


