# Proyecto página web TCU Canazo

## Migración
- Es necesario agregar lo siguiente en sites/default/settings.php para mayor seguridad (https://www.drupal.org/docs/installing-drupal/trusted-host-settings).
```
$settings['trusted_host_patterns'] = [
  '^www\.example\.com$',
  '^example\.com$',
];
```

## Rendimiento
Se desactivaron ciertas opciones para poder desarrollar:
- En Rendimiento, OPTIMIZACIÓN DE ANCHO DE BANDA, se desactivaron las dos opciones de css y JavaScript.
- En /sites/development.services.yml se agregó una sección twig.config en parameters. Esta sección tiene que ser borrada una vez la página entre en producción.

## Herramientas externas a Drupal 8
### Gulp.js
Se instaló Node.js.
```
sudo apt update
sudo apt install nodejs npm
```
Además, Gulp.js.
```
sudo npm install -g gulp-cli
```

Por último, gracias a los archivos gulpfile.js y package.json, se usó Node.js para poder instalar las librerías.
```
sudo npm install
```

Con el entorno ya establecido, para hacer cambios en la carpeta scss y/o lib (para hacer cambios en el tema), es necesario correr el siguiente comando **antes** de hacer dichos cambios.
```
sudo gulp watch
```
El comando anterior estará "escuchando" los cambios y los guardará minificados en las carpetas css y js.
