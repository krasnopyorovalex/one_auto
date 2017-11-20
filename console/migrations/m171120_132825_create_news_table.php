<?php

use yii\db\Migration;

/**
 * Handles the creation of table `news`.
 */
class m171120_132825_create_news_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('news', [
            'id' => $this->primaryKey(),
            'name' => $this->string(512)->notNull(),
            'title' => $this->string(512)->notNull(),
            'description' => $this->string(512)->notNull(),
            'text' => $this->text(),
            'preview' => $this->text(),
            'image' => $this->string(64)->notNull(),
            'image_alt' => $this->string(512)->notNull(),
            'image_title' => $this->string(512)->notNull(),
            'alias' => $this->string()->notNull()->unique(),
            'date' => $this->date(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('news');
    }
}
