<?php

use yii\db\Migration;

/**
 * Handles the creation of table `article`.
 */
class m180215_193740_create_article_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('article', [
            'id' => $this->primaryKey(11),
            'title' => $this->string(),
            'description' => $this->text(),
            'content' => $this->text(),
            'date' => $this->string(),
            'image' => $this->string(),
            'user_id' => $this->integer(),
            'category_id' => $this->integer(),
            'status' => $this->integer()->defaultValue(0),

        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {

        $this->dropTable('article');
    }
}
