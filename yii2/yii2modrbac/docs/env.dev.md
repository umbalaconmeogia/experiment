# Development environment setup

## Web server setup

### DB setup

1. Create PostgreSQL database
  * Open PostgreSQL shell
    ```shell
    psql -U postgres
    ```
  * Run SQL command
    ```SQL
    CREATE USER yii2mod_demo WITH PASSWORD 'yii2mod_demo';
    
    CREATE DATABASE yii2mod_demo;
    GRANT ALL PRIVILEGES ON DATABASE yii2mod_demo TO yii2mod_demo;
    
    \q # quit
    ```
2. Drop database
  ```SQL
  DROP DATABASE IF EXISTS yii2mod_demo;
  ```

## Migrate
```shell
./yii migrate
./yii migrate/up --migrationPath=@yii/rbac/migrations
./yii migrate --migrationPath=@vendor/yii2mod/yii2-comments/migrations
```
