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
    CREATE USER yii2_i18n WITH PASSWORD 'yii2_i18n';

    CREATE DATABASE yii2_i18n;
    GRANT ALL PRIVILEGES ON DATABASE yii2_i18n TO yii2_i18n;

    \q # quit
    ```
2. Drop database
  ```SQL
  DROP DATABASE IF EXISTS yii2_i18n;
  ```