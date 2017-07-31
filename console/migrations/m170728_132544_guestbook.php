<?php

use yii\db\Migration;

class m170728_132544_guestbook extends Migration
{
    public function up()
    {

        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%guestbook}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
            'text' => $this->text(),
            'city' => $this->string('255')->notNull(),
            'image' => $this->string(512)->notNull(),
            'image_title' => $this->string(512)->notNull(),
            'image_alt' => $this->string(512)->notNull(),
            'pos' => $this->integer()->defaultValue(0),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ],$tableOptions);

    }

    public function down()
    {
        $this->dropTable('{{%guestbook}}');
    }
}
