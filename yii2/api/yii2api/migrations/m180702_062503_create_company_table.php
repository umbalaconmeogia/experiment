<?php

use batsg\migrations\BaseMigrationCreateTable;

/**
 * Handles the creation of table `company`.
 */
class m180702_062503_create_company_table extends BaseMigrationCreateTable
{
    protected $table = 'company';
    
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTableWithExtraFields($this->table, [
            'uuid' => $this->string(),
            'name' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable($this->table);
    }
}
