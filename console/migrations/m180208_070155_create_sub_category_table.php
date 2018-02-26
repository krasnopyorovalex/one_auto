<?php

use yii\db\Migration;

/**
 * Handles the creation of table `sub_category`.
 */
class m180208_070155_create_sub_category_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('sub_category', [
            'id' => $this->primaryKey(),
            'category_id' => $this->integer()->notNull(),
            'name' => $this->string(512)->notNull(),
            'text' => $this->text(),
            'alias' => $this->string()->notNull(),
            'image' => $this->string(36),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull()
        ],$tableOptions);

        $this->createIndex('{{%idx-sub_category-category_id}}', '{{%sub_category}}', 'category_id');
        $this->createIndex('{{%idx-sub_category-alias}}', '{{%sub_category}}', 'alias', true);

        $this->addForeignKey('{{%fk-sub_category-category_id}}', '{{%sub_category}}', 'category_id', '{{%category}}', 'id');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('sub_category');
    }
}
