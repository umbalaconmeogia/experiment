<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'sqlite:@app/data/yii2modrbac.sqlite',
	'dsn' => 'pgsql:host=localhost;dbname=yii2mod_demo',
    'username' => 'yii2mod_demo',
    'password' => 'yii2mod_demo',
    'charset' => 'utf8',

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];
