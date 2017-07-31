<?php

use yii\db\Migration;

class m170727_145311_slider_text extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%slider_text}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull()
        ],$tableOptions);

        $this->createTable('{{%slider_text_items}}', [
            'id' => $this->primaryKey(),
            'text' => $this->text(),
            'slider_text_id' => $this->integer(),
            'pos' => $this->integer()->defaultValue(0)
        ],$tableOptions);

        $this->addForeignKey('fk-slider_text_items-slider_text_id', '{{%slider_text_items}}', 'slider_text_id', '{{%slider_text}}', 'id', 'SET NULL', 'RESTRICT');

    }

    public function down()
    {
        $this->dropTable('{{%slider_text_items}}');
        $this->dropTable('{{%slider_text}}');
    }
}
