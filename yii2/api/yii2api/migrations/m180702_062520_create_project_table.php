<?php

use batsg\migrations\BaseMigrationCreateTable;

/**
 * Handles the creation of table `project`.
 */
class m180702_062520_create_project_table extends BaseMigrationCreateTable
{
    protected $table = 'project';
    
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTableWithExtraFields($this->table, [
            'uuid' => $this->string(),
            'name' => $this->string(),
            'company_id' => $this->integer(),
        ]);
        $this->addForeignKeys($this->table, 'company_id', 'company', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable($this->table);
    }
}
