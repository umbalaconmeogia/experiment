# Database command

## Prepare for PostgreSQL

* Open postgres shell
    On Windows
    ```shell
    psql -U postgres
    ```
* Create database
    ```sql
    CREATE USER staticpages WITH PASSWORD 'staticpages';

    CREATE DATABASE staticpages;
    GRANT ALL PRIVILEGES ON DATABASE staticpages TO staticpages;
    ```

## Prepare for MySQL

* Create database
TBD

## Prepare for SQLite

At this time, because model `Page` uses `NOW()` expression, `bupy7/yii2-pages` does not work with sqlite.
I've reported it to the author [here]()