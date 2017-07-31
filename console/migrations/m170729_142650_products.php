<?php

use yii\db\Migration;

class m170729_142650_products extends Migration
{
    public function up()
    {

        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%products}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(512)->notNull(),
            'description' => $this->text(),
            'price' => $this->string('255')->notNull(),
            'pos' => $this->integer()->defaultValue(0),
            'btn_text' => $this->string(64)->notNull(),
            'form_type' => $this->integer()
        ],$tableOptions);

    }

    public function down()
    {
        $this->dropTable('{{%products}}');
    }
}
