<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'sqlite:@app/../../../secure/yii2rbac/yii2rbac.sqlite',
//     'dsn' => 'pgsql:host=localhost;dbname=yii2rbac',
    'username' => 'yii2rbac',
    'password' => 'yii2rbac',
    'charset' => 'utf8',

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];
