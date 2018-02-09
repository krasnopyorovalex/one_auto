<?php

use yii\db\Migration;

/**
 * Handles the creation of table `auto_brand`.
 */
class m180209_122555_create_auto_brand_table extends Migration
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

        $this->createTable('auto_brand', [
            'id' => $this->primaryKey(),
            'name' => $this->string(512)->notNull(),
            'alias' => $this->string()->notNull()
        ],$tableOptions);

        $this->createIndex('{{%idx-auto_brand-alias}}', '{{%auto_brand}}', 'alias', true);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('auto_brand');
    }
}
