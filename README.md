# Proyecto página web TCU Canazo

## Migración
- Es necesario agregar lo siguiente en sites/default/settings.php para mayor seguridad (https://www.drupal.org/docs/installing-drupal/trusted-host-settings).
```
$settings['trusted_host_patterns'] = [
  '^www\.example\.com$',
  '^example\.com$',
];
```
