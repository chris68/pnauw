<?php

use yii\db\Schema;

class m130524_201442_init extends \yii\db\Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user}}', [
            'id' => Schema::TYPE_PK,
            'username' => Schema::TYPE_STRING . ' NOT NULL UNIQUE',
            'auth_key' => Schema::TYPE_STRING . '(32) NOT NULL',
            'password_hash' => Schema::TYPE_STRING . ' NOT NULL',
            'password_reset_token' => Schema::TYPE_STRING . ' UNIQUE',
            'email' => Schema::TYPE_STRING . ' NOT NULL UNIQUE',

            'status' => Schema::TYPE_SMALLINT . ' NOT NULL DEFAULT 10',
            'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            'updated_at' => Schema::TYPE_INTEGER . ' NOT NULL',

            // use additionally real timestamp instead of unix time save as int
            'create_time' => Schema::TYPE_TIMESTAMP.' NOT NULL',
            'update_time' => Schema::TYPE_TIMESTAMP.' NOT NULL',

            // The default role the user has
            'role' => Schema::TYPE_SMALLINT . ' NOT NULL DEFAULT 10',

        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%user}}');
    }
}
