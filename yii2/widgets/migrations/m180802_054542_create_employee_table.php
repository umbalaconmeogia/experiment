<?php

use batsg\migrations\BaseMigrationCreateTable;

/**
 * Handles the creation of table `employee`.
 */
class m180802_054542_create_employee_table extends BaseMigrationCreateTable
{
    protected $table = 'employee';

    public function createDbTable()
    {
        $this->createTableWithExtraFields($this->table, [
            'name' => $this->string(),
            'company_id' => $this->integer(),
            'gender' => $this->tinyInteger(),
        ]);
    }
}
