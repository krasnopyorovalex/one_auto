<?php

use yii\db\Migration;

/**
 * Handles the creation of table `products`.
 */
class m180208_141533_create_products_table extends Migration
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

        $this->createTable('products', [
            'id' => $this->primaryKey(),
            'subcategory_id' => $this->integer()->notNull(),
            'name' => $this->string(512)->notNull(),
            'text' => $this->text(),
            'alias' => $this->string()->notNull(),
            'price' => $this->integer()->notNull()->defaultValue(0),
            'articul' => $this->string(128),
            'maker' => $this->string(255),
            'image' => $this->string(36),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull()
        ],$tableOptions);

        $this->createIndex('{{%idx-products-sub_subcategory_id}}', '{{%products}}', 'subcategory_id');
        $this->createIndex('{{%idx-products-alias}}', '{{%products}}', 'alias', true);

        $this->addForeignKey('{{%fk-products-category_id}}', '{{%products}}', 'subcategory_id', '{{%sub_sub_category}}', 'id');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('products');
    }
}
