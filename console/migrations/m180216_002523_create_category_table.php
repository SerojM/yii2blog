<?php

use yii\db\Migration;

/**
 * Handles the creation of table `category`.
 */
class m180216_002523_create_category_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('category', [
            'id' => $this->primaryKey(),
            'parent_id'=>$this->integer(),
            'title'=>$this->string(),

        ]);
        $this->batchInsert('category', ['parent_id', 'title'], [
            ['', 'Music'],
            ['', 'Kino'],
            ['1', 'Jazz'],
            ['1', 'Rock'],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('category');
    }
}
