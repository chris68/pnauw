<?php

use yii\db\Migration;

class m130524_201442_init extends Migration
{
// @chris68
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'email' => $this->string()->notNull()->unique(),

            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),

// @chris68
            // use additionally real timestamp instead of unix time save as int
            'create_time' => $this->timestamp()->notNull(),
            'update_time' => $this->timestamp()->notNull(),

            // The default role the user has
            'role' => $this->smallInteger()->notNull()->defaultValue(10),
        ], $tableOptions);
    }

// @chris68
    public function safeDown()
    {
        $this->dropTable('{{%user}}');
    }
}
