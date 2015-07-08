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
            'username' => Schema::string()->notNull()->unique(),
            'auth_key' => Schema::string(32)->notNull(),
            'password_hash' => Schema::string()->notNull(),
            'password_reset_token' => Schema::string()->unique(),
            'email' => Schema::string()->notNull()->unique(),

            'status' => Schema::smallInteger()->notNull()->default(10),
            'created_at' => Schema::integer()->notNull(),
            'updated_at' => Schema::integer()->notNull(),

            // use additionally real timestamp instead of unix time save as int
            'create_time' => Schema::timestamp()->notNull(),
            'update_time' => Schema::timestamp()->notNull(),

            // The default role the user has
            'role' => Schema::smallInteger()->notNull()->default(10),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%user}}');
    }
}
