<?php

use yii\db\Migration;

/**
 * Handles the creation of table `users`.
 */
class m180215_194211_create_users_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('users', [
            'id' => $this->primaryKey(),
            'username'=>$this->string(),
            'email'=>$this->string(),
            'password'=>$this->string(),
            'isAdmin'=>$this->integer()->defaultValue(0),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('users');
    }
}
