<?php

use yii\db\Migration;

/**
 * Class m201027_193257_create_table_post
 */
class m201027_193257_create_table_post extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%post}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255)->notNull(),
            'content' => $this->text()->notNull(),
            'resource' => $this->string(255)->notNull(),
            'origin' => $this->text()->null(),
            'active' => $this->smallInteger(1)->defaultValue(1),
            'image' => $this->string(255)->null(),
            'image_ext' => $this->string(255)->null(),
            'views' => $this->integer()->null(),
            'alias' => $this->string(255)->null(),
            'created_at' => $this->integer()->null(),
            'updated_at' => $this->integer()->null(),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%post}}');
    }
}
