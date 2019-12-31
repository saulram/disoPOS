# disoPOS
 Repo de Point of Sale en PHP

Para realizar la instalacion del sistema se requiere:

1.- Instalar XAMPP
2.- Clonar el repositorio dentro de la carpeta htdocs de XAMPP dependiendo del SO.
3.- En la raiz del sistema crear fichero htaccess

4.- Configurar fichero htaccess con lo siguiente.:

---------------
Options All -Indexes
RewriteEngine On 
RewriteRule ^([-a-zA-Z0-9/]+)$ index.php?ruta=$1
----------

5.- Importar en phpmyadmin el archivo database.sql.
6.-Modificar en /modelos/conexion.php los datos de conexion a la base de datos local.
7.- arrancar xampp y dirigirse a localhost/rutaalsistema.
