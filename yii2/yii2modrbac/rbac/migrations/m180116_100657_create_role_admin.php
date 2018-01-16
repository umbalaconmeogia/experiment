<?php

use yii2mod\rbac\migrations\Migration;

class m180116_100657_create_role_admin extends Migration
{
    public function safeUp()
    {
        $this->createRole('admin01', 'admin has all available permissions.');
    }

    public function safeDown()
    {
        $this->removeRole('admin01');
    }
}