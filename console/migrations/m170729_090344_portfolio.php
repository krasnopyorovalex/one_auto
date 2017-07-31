<?php

use yii\db\Migration;

class m170729_090344_portfolio extends Migration
{
    public function up()
    {

        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%portfolio}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
            'domain' => $this->string(128)->notNull(),
            'description' => $this->text(),
            'pos' => $this->integer()->defaultValue(0)
        ],$tableOptions);

        $this->createTable('{{%portfolio_images}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(32)->notNull(),
            'ext' => $this->string(4)->notNull(),
            'pos' => $this->integer()->defaultValue(0),
            'alt' => $this->string(512),
            'title' => $this->string(512),
            'portfolio_id' => $this->integer(),
        ],$tableOptions);

        $this->addForeignKey('fk-portfolio_images-portfolio_id', '{{%portfolio_images}}', 'portfolio_id', '{{%portfolio}}', 'id', 'CASCADE', 'RESTRICT');

    }

    public function down()
    {
        $this->dropTable('{{%portfolio_images}}');
        $this->dropTable('{{%portfolio}}');
    }
}
