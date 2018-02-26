<?php

namespace common\models;


use Yii;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;

/**
 * This is the model class for table "article".
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property string $content
 * @property string $date
 * @property string $image
 * @property int $user_id
 * @property int $category_id
 * @property int $status
 *
 * @property ArticleTag[] $articleTags
 */
class Article extends \yii\db\ActiveRecord
{
    public $sub_category;
    public $hidden_val;

    public static function tableName()
    {
        return 'article';
    }

    public function rules()
    {
        return [
            [['title', 'category_id','description','content'], 'required'],
            [['category_id'], 'string'],
            [['title', 'description', 'content'], 'string'],
            [['date'], 'date', 'format' => 'php:F j, Y, g:i a'],
            [['date'], 'default', 'value' => date("F j, Y, g:i a")],
            [['title'], 'string', 'min' => 3, 'max' => 255],
            [['image'], 'file', 'extensions' => 'jpg,png,jpeg']
        ];
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'description' => 'Description',
            'content' => 'Content',
            'date' => 'Date',
            'image' => 'Image',
            'user_id' => 'Creator',
            'category_id' => 'Category',
            'status' => 'Status',
            'sub_category' => 'Subcategory'
        ];
    }

    public function uploadFile($file, $hid_img = null, $current_img = null)
    {
        if (!empty($file) || $file != null) {
            $file_name = $this->generateFileName($file);
            $file->saveAs($this->getFolder() . $file_name);
            if ($hid_img != null && $hid_img != "no_image.png") {
                unlink(Yii::getAlias('@common/' . 'uploads/') . $hid_img);
            }
        } else {
            $file_name = $hid_img;
            if ($hid_img == null) {
                if ($current_img != null && $current_img != 'no_image.png') {
                    unlink(Yii::getAlias('@common/' . 'uploads/') . $current_img);
                }
                $file_name = 'no_image.png';
            }
        }
        return $file_name;
    }

    private function getFolder()
    {
        return Yii::getAlias('@common/' . 'uploads/');
    }

    private function generateFileName($file)
    {
        return strtolower(md5(uniqid($file->baseName))) . '.' . $file->extension;
    }

    public function getAuthor(){
        return $this->hasOne(Users::className(),['id'=>'user_id']);
    }
    public function getArticleTags()
    {
        return $this->hasMany(ArticleTag::className(), ['article_id' => 'id']);
    }

    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    public function getTags()
    {
        return $this->hasMany(Tag::className(), ['id' => 'tag_id'])
            ->viaTable('article_tag', ['article_id' => 'id']);
    }

    public function getImage()
    {
        return Yii::getAlias('@image_path/') . $this->image;
    }

    public function getSelectedTags()
    {
        $selectedTags = $this->getTags()->select('id')->asArray()->all();
        return ArrayHelper::getColumn($selectedTags, 'id');
    }

    public function saveTagArticle($tags, $lastSaveId)
    {
        $tag_art = new ArticleTag();
        $values = [];
        foreach ($tags as $tag_id) {
            $values[] = [$lastSaveId, $tag_id];
        }
        // can do with link()
        self::getDb()->createCommand()
            ->batchInsert(ArticleTag::tableName(), ['article_id', 'tag_id'], $values)->execute();

    }

    public function clearCurrentTags($id)
    {
        ArticleTag::deleteAll(['article_id' => $id]);
    }

    public static function getAll($pageSize = 5)
    {
        $query = Article::find()->where(['status'=>10])->orderBy(['id'=>SORT_DESC]);
        $count = $query->count();
        $pagination = new Pagination(['totalCount' => $count, 'pageSize' => $pageSize]);
        $articles = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();
        $data['articles'] = $articles;
        $data['pagination'] = $pagination;
        return $data;
    }
    public static function getArticlesByCategory($id,$pageSize = 5){
        $cats = Category::find()->where(['parent_id'=>$id])->all();
        $sub_id = [$id];
        foreach ($cats as $cat) {
            $sub_id[] = $cat['id'];
        }
        $query = Article::find()->where(['category_id'=>$sub_id,'status'=>10])->orderBy(['id'=>SORT_DESC]);
        $count = $query->count();
        $pagination = new Pagination(['totalCount' => $count, 'pageSize' => $pageSize]);
        $articles = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();
        $data['articles'] = $articles;
        $data['pagination'] = $pagination;
        return $data;
    }
    public static function getArticlesByStatus($pageSize = 5){
        $query = Article::find()->where(['status'=>0])->orderBy(['id'=>SORT_DESC]);
        $count = $query->count();
        $pagination = new Pagination(['totalCount' => $count, 'pageSize' => $pageSize]);
        $articles = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();
        $data['articles'] = $articles;
        $data['pagination'] = $pagination;
        return $data;
    }
    public static function getArticlesByUser($pageSize = 5){

        $query = Article::find()->where(['user_id'=>Yii::$app->user->id])->orderBy(['id'=>SORT_DESC]);
        $count = $query->count();
        $pagination = new Pagination(['totalCount' => $count, 'pageSize' => $pageSize]);
        $articles = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();
        $data['articles'] = $articles;
        $data['pagination'] = $pagination;
        return $data;
    }

}
