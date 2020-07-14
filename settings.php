<?php

/**
 * A quick start lando settings.php to put in sites/default.
 */

$settings["config_sync_directory"] = '../config';

$databases['default']['default'] = [
  'database' => 'drupal9',
  'username' => 'drupal9',
  'password' => 'drupal9',
  'prefix' => '',
  'host' => 'database',
  'port' => '3306',
  'namespace' => 'Drupal\\Core\\Database\\Driver\\mysql',
  'driver' => 'mysql',
];
$settings['install_profile'] = 'minimal';

