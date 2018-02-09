<?php

use yii\db\Migration;

/**
 * Handles the creation of table `auto_model`.
 */
class m180209_122715_create_auto_model_table extends Migration
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
        $this->createTable('auto_model', [
            'id' => $this->primaryKey(),
            'brand_id' => $this->integer()->notNull(),
            'name' => $this->string(512)->notNull(),
            'alias' => $this->string()->notNull()
        ],$tableOptions);

        $this->createIndex('{{%idx-auto_model-brand_id}}', '{{%auto_model}}', 'brand_id');
        $this->createIndex('{{%idx-auto_model-alias}}', '{{%auto_model}}', 'alias', true);

        $this->addForeignKey('{{%fk-auto_model-brand_id}}', '{{%auto_model}}', 'brand_id', '{{%auto_brand}}', 'id');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('auto_model');
    }
}
