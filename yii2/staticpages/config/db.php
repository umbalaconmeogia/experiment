<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'sqlite:@app/data/pages.sqlite',
    'dsn' => 'pgsql:host=localhost;dbname=staticpages',
    'username' => 'staticpages',
    'password' => 'staticpages',
    'charset' => 'utf8',

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];
