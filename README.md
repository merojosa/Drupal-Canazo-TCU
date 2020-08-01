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
