<?php

use yii\db\Migration;

/**
 * Handles the creation of table `products_attributes`.
 */
class m180209_081716_create_products_attributes_table extends Migration
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

        $this->createTable('products_options', [
            'id' => $this->primaryKey(),
            'name' => $this->string(512)->notNull()
        ],$tableOptions);

        $this->createTable('{{%products_options_via}}', [
            'product_id' => $this->integer()->notNull(),
            'option_id' => $this->integer()->notNull(),
            'value' => $this->string(512)->notNull(),
        ],$tableOptions);

        $this->addPrimaryKey('pk-products_options_via', '{{%products_options_via}}', ['product_id', 'option_id']);

        $this->createIndex('idx-products_options_via-product_id', '{{%products_options_via}}', 'product_id');
        $this->createIndex('idx-products_options_via-option_id', '{{%products_options_via}}', 'option_id');

        $this->addForeignKey('fk-products_options_via-product', '{{%products_options_via}}', 'product_id', '{{%products}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('fk-products_options_via-option', '{{%products_options_via}}', 'option_id', '{{%products_options}}', 'id', 'CASCADE', 'RESTRICT');

    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('products_attributes');
    }
}
