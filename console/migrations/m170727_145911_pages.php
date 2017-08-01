<?php

use yii\db\Migration;

class m170727_145911_pages extends Migration
{
    public function up()
    {

        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%pages}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(512)->notNull(),
            'title' => $this->string(512)->notNull(),
            'description' => $this->string(512)->notNull(),
            'text' => $this->text(),
            'alias' => $this->string()->notNull()->unique(),
            'slider_text_id' => $this->integer(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ],$tableOptions);

        $this->createIndex('idx-pages-alias', '{{%pages}}', 'alias');

        $this->addForeignKey('fk-pages-slider_text_id', '{{%pages}}', 'slider_text_id', '{{%slider_text}}', 'id', 'SET NULL', 'RESTRICT');

        $this->insert('{{%pages}}', [
            'name'        => 'ООО «Красбер»',
            'title'       => 'Мы будем рвать всех:) ООО «Красбер»',
            'description' => '',
            'text'        => '',
            'alias'       => 'index',
            'created_at'  => time(),
            'updated_at'  => time()
        ]);
    }

    public function down()
    {
        $this->dropTable('{{%pages}}');
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
