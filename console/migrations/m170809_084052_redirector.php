<?php

use yii\db\Migration;

class m170809_084052_redirector extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%redirects}}', [
            'id' => $this->primaryKey(),
            'old_alias' => $this->string(512)->notNull(),
            'new_alias' => $this->string(512)->notNull(),
            'date' => $this->integer()->notNull()
        ],$tableOptions);

        $this->createIndex('idx-redirects-old_alias', '{{%redirects}}', 'old_alias');
        $this->createIndex('idx-redirects-new_alias', '{{%redirects}}', 'new_alias');
    }

    public function down()
    {
        $this->dropTable('{{%redirects}}');
    }
}
