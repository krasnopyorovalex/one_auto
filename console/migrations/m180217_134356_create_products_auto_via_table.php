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
            'auto_model_id' => $this->integer()
        ]);

        $this->addPrimaryKey('pk-products_auto_via', '{{%products_auto_via}}', ['product_id', 'auto_model_id']);

        $this->createIndex('idx-products_auto_via-product_id', '{{%products_auto_via}}', 'product_id');
        $this->createIndex('idx-products_auto_via-auto_model_id', '{{%products_auto_via}}', 'auto_model_id');

        $this->addForeignKey('fk-products_auto_via-product', '{{%products_auto_via}}', 'product_id', '{{%products}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('fk-products_auto_via-auto_model', '{{%products_auto_via}}', 'auto_model_id', '{{%auto_models}}', 'id', 'CASCADE', 'RESTRICT');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('products_auto_via');
    }
}
