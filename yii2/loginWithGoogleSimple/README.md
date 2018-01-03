# Implement login with Google on yii2 based system

This example describes the simplest integration of login with Google account in yii2 system.
For simplicity, no more login method (such as via username/password) is implemented.

## Overview

I use the basic template of yii2 2.0.13 to create this example.

## Create Google credential and enable Google+ API

Register the Google Client ID for Web Application and enable the Google+ API for it.

| Item | Value |
| --- | --- |
| Name | Login With Google Simple |
| Authorised Javascript origins | http://localhost |
| Authrosed redirect URIs | http://localhost/openSource/experiment.github/yii2/loginWithGoogleSimple/web/index.php?r=site%2Fauth&authclient=google |

## Implementation

### Preparation

This section does not relate to implementation of login with Google, but I must do this to protected my private data (such as Google API credentials and SQLite database file) from possibility of being commited to github.

I create a folder called `secure` at the same level of this Git working directory, and put my secret data into it.

I create a file called `secure/loginWithGoogleSimple/config.php` and define some data in it as following. This file will be required in yii2 `config/web.php` to set credentials data for authClientCollection

```php
<?php
return [
    'oauthGoogleClientId' => 'xxxxxxxxxxxxxxxx.apps.googleusercontent.com',
    'oauthGoogleClientSecret' => 'xxxxxxxxxxxxxxxx',
];
```

I use SQLite for this example, and the SQLite database file is put in this `secure/loginWithGoogleSimple` directory, too. This is defined in `config/db.php`.

### Add yii2-authclient component

I use yii2-authclient extension. Open compose.json, add yii2-authclient into require field.
```javascript
    "require": {
        // Another setting, remember to add comma (,) to the end of the last element.
        "yiisoft/yii2-authclient": "*"
    },
```
then run
```bash
composer update
```
This will update yii2 framework and other extensions, too.

You can run
`composer require "yiisoft/yii2-authclient"` instead of steps above. But in my case, extension like sebastian/diff requires PHP 7, which is not my enviroment. Adding yii2-authclient manually as above does not require PHP 7.

### Configure web application

Edit config/web.php as below
```php
<?php
// Load some Google Authentication information from external file.
// This file returns an array that holds data as key-value pairs.
$systemConfig = require __DIR__ . '/../../../../secure/loginWithGoogleSimple/config.php';

$config = [
    'components' => [
        'authClientCollection' => [
            'class' => 'yii\authclient\Collection',
            'clients' => [
                'google' => [
                    'class' => 'yii\authclient\clients\Google',
                    'clientId' => $systemConfig['oauthGoogleClientId'],
                    'clientSecret' => $systemConfig['oauthGoogleClientSecret'],
                ],
            ],
        ],
        // Another settings.
    ],
    // Another settings.
];
```

Edit config/db.php as below
```php
<?php
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'sqlite:@app/../../../secure/loginWithGoogleSimple/loginWithGoogleSimple.sqlite',
    'charset' => 'utf8',
];
```

### Prepare DB and model classes

Run `yii migrate` to create database tables.

Create corresponding models Auth and User (overwrite the default User model).

### Edit controller and view

* Edit controllers/SiteController.php as below

  * Add 'auth' action definition into function actions()
  ```php
      public function actions()
      {
          return [
              'auth' => [
                  'class' => 'yii\authclient\AuthAction',
                  'successCallback' => [$this, 'onAuthSuccess'],
              ],
              // Another definition
          ];
      }
  ```

  * Add function `onAuthSuccess($client)` and relative function `getGoogleUserEmail($attributes)`.

* Edit views/site/login.php as below to remove the login form, and replace it by Google login account.
```php
<?php
$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<?= yii\authclient\widgets\AuthChoice::widget([
     'baseAuthUrl' => ['site/auth'],
     'popupMode' => false,
]) ?>
```

## Reference

* Yii2 Auth Clients
I create this example based on this article (although its code may not work with the current Google API, don't know if it's bug or Google API changed).
https://yii2-framework.readthedocs.io/en/stable/guide/security-auth-clients/

* Login with google using dektrium/yii2-user.
Although there are some bugs in the tutorial, it helps me starting with login with Google ID.
https://code.tutsplus.com/tutorials/how-to-program-with-yii2-google-authentication--cms-24987

