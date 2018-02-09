<?php

use yii\db\Migration;

/**
 * Handles the creation of table `auto_generation`.
 */
class m180209_122725_create_auto_generation_table extends Migration
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
        $this->createTable('auto_generation', [
            'id' => $this->primaryKey(),
            'model_id' => $this->integer()->notNull(),
            'name' => $this->string(512)->notNull(),
            'alias' => $this->string()->notNull()
        ],$tableOptions);

        $this->createIndex('{{%idx-auto_generation-model_id}}', '{{%auto_generation}}', 'model_id');
        $this->createIndex('{{%idx-auto_generation-alias}}', '{{%auto_generation}}', 'alias', true);

        $this->addForeignKey('{{%fk-auto_generation-model_id}}', '{{%auto_generation}}', 'model_id', '{{%auto_model}}', 'id');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('auto_generation');
    }
}
