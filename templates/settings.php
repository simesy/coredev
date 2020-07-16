<?php

/**
 * A quick start lando settings.php to put in sites/default.
 */

$settings["config_sync_directory"] = '../config';
$settings['hash_salt'] = 'nxeSYAATKsKNnDJ0ik6C-mHCSHedE9qqxgNlQH6Lh_W1niOF38xus1ge9WXSphhFcQY29cpyXg';

$databases['default']['default'] = [
  'database' => 'drupal',
  'username' => 'drupal',
  'password' => 'drupal',
  'prefix' => '',
  'host' => 'database',
  'port' => '3306',
  'namespace' => 'Drupal\\Core\\Database\\Driver\\mysql',
  'driver' => 'mysql',
];

// May want to be able to turn this on and off to emulate default drupal.
if (1 == 1) {
  // Turn on debugging of all sorts.

  $settings['container_yamls'][] = DRUPAL_ROOT . '/sites/default/services.yml';

  $settings['cache']['bins']['render'] = 'cache.backend.null';
  $settings['cache']['bins']['dynamic_page_cache'] = 'cache.backend.null';
  $settings['cache']['bins']['page'] = 'cache.backend.null';
  $settings['twig_debug'] = TRUE;
  $config['system.performance']['css']['preprocess'] = FALSE;
  $config['system.performance']['js']['preprocess'] = FALSE;
  $config['system.logging']['error_level'] = 'verbose';

  error_reporting(E_ALL);
  ini_set('display_errors', TRUE);
  ini_set('display_startup_errors', TRUE);

  $settings['update_free_access'] = TRUE;
  $settings['rebuild_access'] = FALSE;

  $config['system.logging']['error_level'] = 'verbose';

  $settings['trusted_host_patterns'] = [
    '^' . getenv('LANDO_APP_NAME') . '\.lndo\.site$',      # lando proxy access
    '^' . getenv('LANDO_APP_NAME') . '\.localtunnel\.me$', # lando share access
    '^localhost$',                                     # localhost access
  ];
}

$settings['install_profile'] = 'minimal';
