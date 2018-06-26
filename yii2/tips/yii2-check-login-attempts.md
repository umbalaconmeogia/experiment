# Restrict login attempt

To avoid Brute Force login attacking, use giannisdag/yii2-check-login-attempts to restrict the wrong login times.

Use [giannisdag/yii2-check-login-attempts](https://github.com/giannisdag/yii2-check-login-attempts)

1. Install the extension.
```shell
composer require giannisdag/yii2-check-login-attempts
```
2. Run the migration. This will add table *login_attempt* into the DB.
```shell
./yii migrate --migrationPath="@vendor/giannisdag/yii2-check-login-attempts/src/migrations"
```
3. Update the app\models\LoginForm by adding the behavior() function
```php
public function behaviors()
{
  $behaviors = parent::behaviors();

  $behaviors[] = [
      'class' => '\giannisdag\yii2CheckLoginAttempts\behaviors\LoginAttemptBehavior',

      // Amount of attempts in the given time period
      'attempts' => 2,

      // the attribute used as the key in the database
      // and add errors to
      'usernameAttribute' => 'username',
  ];

  return $behaviors;
}
```