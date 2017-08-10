<?php

use yii\db\Migration;

class m170810_121633_blocks extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%blocks}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(512)->notNull(),
            'price' => $this->text(),
            'description' => $this->text(),
            'btn_text' => $this->string(64)->notNull(),
            'color' => $this->string(16)->notNull()
        ],$tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%blocks}}');
    }
}
