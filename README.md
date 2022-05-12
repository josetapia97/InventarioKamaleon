## Autor
   *`Jose Tapia Jara`, Alumno practicante de `Ingeniería Civil Informática` de la `Universidad Católica del Maule` en la empresa `KAMALEON`.

## Problematica
Este trabajo busca dar solución a la problemática de la empresa Kamaleon que se explica a continuación:

   * La empresa cuenta con muchos activos tecnológicos los cuales no mantiene la trazabilidad de su paradero o estado, esto a su vez puede suponer una pérdida de dinero en caso de querer arrendar alguno de dichos activos y no contar con su paradero, o bien, comprar artículos nuevos sin saber que ya cuentan con ellos en algún lugar en desuso.

## Solución
La solución empleada en esta trazabilidad del sistema no solo sirve para eso, sino que ayuda a automatizar un reporte asociado a:
   * Las empresas y su patrimonio
   * Las asignaciones de los artículos (activos) a cada trabajador
   * Los artículos y sus características

## Observaciones
   [Obs1] : Además en el sistema se considera el estado de los `activos (nuevo o usado)` junto a su `depreciación con el tiempo`.
   [Obs2] : La aplicación cuenta con un `login centralizado`, es decir, un usuario no puede loguearse o restablecer su contraseña sin que un administrador lo ingrese y le asigne sus respectivos permisos.

## Sistema
Algunas consideraciones para entender el sistema:
   * El sistema ha sido construido mediante la plantilla de bootstrap SBAdmin
   * El sistema cuenta con un evento el cual actualiza la vigencia de los contratos 1 vez al día para que actualicen su vigencia en base a la fecha de termino
   * Cada vista cuenta con su mensajería mediante POST, la cual llega a su respectivo archivo en la carpeta AJAX para pasar finalmente al MODELO en el cual se ejecutan las consultas a la base de datos.
   * La vista de trabajador.php es la unica que se cambio su nombre, ya que en modelo y en ajax se llama usuariofinal, pero se modifico para evitar confusión al administrar
   * Las tecnologías empleadas son `PHP 7.4, MYSQL 8, APACHE2, JQuery 3, MYSQL Workbench 8.0`
   * Se proveen en la carpeta:
        [Imagen] : para representacion visual del modelo de datos
        [Modelo] : de datos en Workbench para eventuales modificaciones
        [BD] : para importar en Mysql
    