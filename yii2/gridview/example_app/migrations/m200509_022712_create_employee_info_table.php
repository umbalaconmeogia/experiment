<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%employee_info}}`.
 */
class m200509_022712_create_employee_info_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%employee_info}}', [
            'id' => $this->primaryKey(),
            'employee_id' => $this->integer()->notNull(),
            'code' => $this->string()->notNull(),
            'value' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%employee_info}}');
    }
}
