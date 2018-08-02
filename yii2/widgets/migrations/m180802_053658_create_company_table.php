<?php

use batsg\migrations\BaseMigrationCreateTable;

/**
 * Handles the creation of table `company`.
 */
class m180802_053658_create_company_table extends BaseMigrationCreateTable
{
    protected $table = 'company';

    protected function createDbTable()
    {
        $this->createTableWithExtraFields($this->table, [
            'name' => $this->string(),
            'country_code' => $this->string(),
        ]);
    }
}
