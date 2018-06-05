# Make only allowed Google account can login to an yii2 based system

## Overview
In this example, only Google account pre-registered by admin can login to system.

It also implement a login attempt checking for longin by username/password, disable account after two login failure.

## Setup

* Install required libraries
```shell
composer update
```
If you don't use MySQL, you must edit giannisdag/yii2-check-login-attempts migration file as the link
https://github.com/giannisdag/yii2-check-login-attempts/issues/3

* Migration
```shell
./yii migrate/up all
./yii migrate/up all --migrationPath="@vendor/giannisdag/yii2-check-login-attempts/src/migrations"
```

* Create admin account
```shell
./yii init-admin
```
The admin account with default password "password" is created.

## Register user that allowed to login to the system.

Login as admin, then create user with google email.
Then, this user can login via Google.