<?php

use yii\db\Migration;

/**
 * Class m201027_193304_create_table_post_category
 */
class m201027_193304_create_table_post_category extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%post_category}}', [
            'id' => $this->primaryKey(),
            'post_id' => $this->integer()->notNull(),
            'category_id' => $this->integer()->notNull(),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%post_category}}');
    }
}
