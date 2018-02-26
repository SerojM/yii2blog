<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "category".
 *
 * @property int $id
 * @property int $parent_id
 * @property string $title
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_id'], 'integer'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parent_id' => 'Parent Category',
            'title' => 'Title',
        ];
    }
    public static function getParent(){
       $category =  Category::find()->where(['parent_id'=>null])->all();
    return $category;
    }
    public function getArticles(){
        return $this->hasMany(Article::className(),['category_id'=>'id']);
    }
    public function getArticlesCount(){
        return $this->getArticles()->count();
    }
    public function getParentCategory(){
        $cats = Category::find()->where(['parent_id'=>$this->id])->all();
        $sub_id = [$this->id];
        foreach ($cats as $cat) {
            $sub_id[] = $cat['id'];
        }
        $query = Article::find()->where(['category_id'=>$sub_id]);

        return  $query;
    }

    public function getArticlesCountInParent(){
       return $this->getParentCategory()->count();
    }

    public static function getSubCategory($id){
        return Category::find()->where(['parent_id' => $id])->all();
    }
}
