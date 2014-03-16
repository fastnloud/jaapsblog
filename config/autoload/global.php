<?php
/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */

return array(
   'db' => array(
        'driver'         => 'Pdo',
        'driver_options' => array(
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''
        ),
    ),
    'auth' => array(
        'realm'     => 'admin',
        'filename'  => __DIR__ . '/../../files/passwd.txt'
    ),
    'website' => array (
        'version'       => '2',
        'title'         => 'Jaapsblog.nl',
        'description'   => 'PHP / ZF2 blog',
        'author'        => '',
        'email'         => ''
    ),
    'mail' => array(
        'from' => 'noreply@jaapsblog.nl',
        'transport' => array(
            'options' => array(
                'host' => 'localhost'
            )
        )
    ),
    'reply_form' => array(
        'send_notification_to' => ''
    ),
    'google' => array(
        'analytics' => array(
            'account' => ''
        )
    ),
    'service_manager' => array(
        'factories' => array(
            'Zend\Db\Adapter\Adapter'
                    => 'Zend\Db\Adapter\AdapterServiceFactory',
        ),
    ),
);
