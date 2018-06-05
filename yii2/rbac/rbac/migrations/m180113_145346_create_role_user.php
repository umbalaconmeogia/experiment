<?php

use yii2mod\rbac\migrations\Migration;

class m180113_145346_create_role_user extends Migration
{
    public function safeUp()
    {
        $this->createRole('admin', 'admin has all available permissions.');
        $this->createRole('user', 'user has some available permissions.');
        $this->createRole('guest', 'guest has no available permissions.');
    }

    public function safeDown()
    {
        $this->removeRole('admin');
        $this->removeRole('user');
        $this->removeRole('guest');
    }
}