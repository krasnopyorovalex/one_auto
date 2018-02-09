<?php

use yii\db\Migration;

/**
 * Handles the creation of table `category`.
 */
class m180208_070148_create_category_table extends Migration
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

        $this->createTable('category', [
            'id' => $this->primaryKey(),
            'catalog_id' => $this->integer()->notNull(),
            'name' => $this->string(512)->notNull(),
            'text' => $this->text(),
            'alias' => $this->string()->notNull(),
            'image' => $this->string(36),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull()
        ],$tableOptions);

        $this->createIndex('{{%idx-category-catalog_id}}', '{{%category}}', 'catalog_id');
        $this->createIndex('{{%idx-category-alias}}', '{{%category}}', 'alias', true);

        $this->addForeignKey('{{%fk-category-catalog_id}}', '{{%category}}', 'catalog_id', '{{%catalog}}', 'id');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('category');
    }
}
