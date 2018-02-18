<?php

use yii\db\Migration;

/**
 * Handles the creation of table `products_auto_via`.
 */
class m180217_134356_create_products_auto_via_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('products_auto_via', [
            'product_id' => $this->integer(),
            'auto_brand_id' => $this->integer()
        ]);

        $this->addPrimaryKey('pk-products_auto_via', '{{%products_auto_via}}', ['product_id', 'auto_brand_id']);

        $this->createIndex('idx-products_auto_via-product_id', '{{%products_auto_via}}', 'product_id');
        $this->createIndex('idx-products_auto_via-auto_brand_id', '{{%products_auto_via}}', 'auto_brand_id');

        $this->addForeignKey('fk-products_auto_via-product', '{{%products_auto_via}}', 'product_id', '{{%products}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('fk-products_auto_via-auto_brand', '{{%products_auto_via}}', 'auto_brand_id', '{{%auto_brands}}', 'id', 'CASCADE', 'RESTRICT');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('products_auto_via');
    }
}
