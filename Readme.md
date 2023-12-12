# Contar palabras de forma irritante

## Descripción

Plugin que cuenta las palabras de forma irritante.

## Instalación

1. *Pega* el archivo **ContarPalabras.php** a la carpeta `/wp-content/plugins/`
2. *Activa* el plugin desde el menú de administración de **WordPress**
3. *Asegurate* de tener una base de datos, donde puedas hacer las inserciones, lecturas y creacion de tablas.

## Uso

1. *Crea* o *visualiza* un post nuevo o ya pre-existente, para poder ver la cantidad de palabras que tenga
2. *Visualiza*  como se cuentan las palabras de forma irritante (en el titulo y en el contenido del post).

## Funcionamiento

**Cuenta** las palabras que tiene el *titulo* y el *contenido* del post, en distintos campos en una misma tabla de la base de 
**datos**, esto es para poder distinguir la cantidad de palabras de un lado con el otro, y al momento de **visualizar** el post,
buscara su id que tambien esta almacenada en una tabla para poder saber la cantidad de palabras que tiene.

Al estarse mostrando solo en la visualizacion del post, no tomara las palabras que agrega para saber que se mostrara la cantidad 
de palabras que tiene el post.

Se muestra la cantidad de palabras solo en la previsualizacion o en la vista de un post, en el titulo y en el contenido del post, al final del titulo con su propia cantidad de palabras y al final de contenido con su propia cantidad de palabras.

## Consideraciones

- De querer ver la cantidad de palabras que tenga un post que no tenga contenido o titulo, en su respectiva zona no mostrara
nada.

## Cambios por mejoria y comodidad de uso

- Se **elimino** la idea de hacer que ingresase a cada rato la cantidad de palabras al hacer que solo se haga con la publicacion para evitar todo el rato
 llamadas a la base de datos.
- Se quito la necesidad de tener que ingresar a la base de datos una tabla nueva por cada nueva publicacion, ya que descubri que los post tiene **id**