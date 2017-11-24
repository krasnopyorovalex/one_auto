<?php

use yii\db\Migration;

/**
 * Handles the creation of table `landings`.
 */
class m171121_151546_create_landings_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('landings', [
            'id' => $this->primaryKey(),
            'name' => $this->string(512)->notNull(),
            'link' => $this->string(128)->notNull(),
            'image' => $this->string(64)->notNull(),
            'image_alt' => $this->string(512)->notNull(),
            'image_title' => $this->string(512)->notNull(),
            'pos' => $this->integer()->defaultValue(0),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull()
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('landings');
    }
}
