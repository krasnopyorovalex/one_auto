<?php

use yii\db\Migration;

/**
 * Handles the creation of table `sub_sub_category`.
 */
class m180208_070255_create_sub_sub_category_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('sub_sub_category', [
            'id' => $this->primaryKey(),
            'sub_category_id' => $this->integer()->notNull(),
            'name' => $this->string(512)->notNull(),
            'text' => $this->text(),
            'alias' => $this->string()->notNull(),
            'image' => $this->string(36),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull()
        ],$tableOptions);

        $this->createIndex('{{%idx-sub_sub_category-category_id}}', '{{%sub_sub_category}}', 'sub_category_id');
        $this->createIndex('{{%idx-sub_sub_category-alias}}', '{{%sub_sub_category}}', 'alias', true);

        $this->addForeignKey('{{%fk-sub_sub_category-sub_category_id}}', '{{%sub_sub_category}}', 'sub_category_id', '{{%sub_category}}', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('sub_sub_category');
    }
}
