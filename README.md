# Integ.ro - Cube Summation

El presente repositorio contine la prueba solicitada para el ingreso.

### Paradigma de desarrollo 1

la primera parte del desarrollo se llevó a cabo en un único archivo, en forma de un script en un unico archivo contenido en la carpeta scripts/cli.php. Este archivo puede ser ejecutado con el siguiente comando:

```sh
$ php cli.php < stdin.txt
```
Esta primera parte se desarrollo así con el fin de proveer el codigo necesario para correrlo en hackerrank

### Paradigma de desarrollo 2

Se desarrolló sobre laravel 5.5, haciendo uso de Programación Orientada a Objetos, creando un servicio  y haciendo uso de Service Container de laravel y la injeccon de dependencias por typehint. Se hizo uso de excepciones para validar los datos de entrada. Para correr el aplicativo de debe correr el siguiente comando:

```sh
$ php artisan sumcube stdin.txt
```
Este comando recibe como argumento el path al archivo que contiene los tests.
