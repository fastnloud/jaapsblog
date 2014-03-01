<?php
return array(
    'modules' => array(
        'Auth',
        'Admin',
        'Blog',
        'Dkim'
    ),
    'module_listener_options' => array(
        'config_glob_paths'    => array(
            'config/autoload/{,*.}{global,local}.php',
        ),
        'module_paths' => array(
            './module',
            './vendor',
        ),
    ),
);
