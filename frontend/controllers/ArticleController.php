<?php

namespace frontend\controllers;


use common\models\ArticleTag;
use common\models\Category;
use common\models\Tag;
use Yii;
use common\models\Article;
use common\models\ArticleSearch;
use yii\helpers\ArrayHelper;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\web\UploadedFile;

/**
 * ArticleController implements the CRUD actions for Article model.
 */
class ArticleController extends Controller
{
    public function actionCreate()
    {
        $model = new Article();
        $selectedTags = '';

        $tags = ArrayHelper::map(Tag::find()->all(), 'id', 'title');
        $category = Category::find()->where(['id'=>$model->category_id])->asArray()->one();
        $category2 = Category::find()->where(['parent_id' => null])->asArray()->all();
        if (!empty($category)){
            $category2[] = $category ;
        }
        $items = ArrayHelper::map($category2, 'id', 'title');

        if ($model->load(Yii::$app->request->post())) {
            $file = UploadedFile::getInstance($model, 'image');
            $file_name = $model->uploadFile($file);
            $model->image = $file_name;
            $model->user_id = Yii::$app->user->id;
            if (isset(Yii::$app->request->post('Article')['sub_category']) && Yii::$app->request->post('Article')['sub_category'] != null ) {
                $model->category_id = Yii::$app->request->post('Article')['sub_category'];
            }
            $model->save();
            $lastSaveId = $model->getPrimaryKey();

            if ( Yii::$app->request->post('tags') && Yii::$app->request->post('tags') != null) {
                $lastSaveId = $model->getPrimaryKey();
                $tags = Yii::$app->request->post('tags');
                $model->saveTagArticle($tags,$lastSaveId);
            }

            return $this->redirect(['/user/articles']);
        }


        return $this->render('create', [
            'model' => $model, 'selectedTags' => $selectedTags, 'tags' => $tags,'items'=>$items
        ]);
    }

    /**
     * Updates an existing Article model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if (Yii::$app->user->id == $model->user_id)
        {
            $article = new Article();
        $current_img = $model->image;

        $art_tag = ArticleTag::find()->where(['article_id'=>$id])->all();
        $val= [];
        foreach ($art_tag as $tag_id){
           $val[] =  $tag_id['tag_id'];
        }
        $category = Category::find()->where(['id'=>$model->category_id])->asArray()->one();
        $category2 = Category::find()->where(['parent_id' => null])->asArray()->all();
        if (!empty($category)){$category2[] = $category ;}
        $items = ArrayHelper::map($category2, 'id', 'title');
        $selectedTags = $model->getSelectedTags();
        $tags = ArrayHelper::map(Tag::find()->all(), 'id', 'title');
        if ($model->load(Yii::$app->request->post())) {

            $file = UploadedFile::getInstance($model, 'image');
            $hid_img = Yii::$app->request->post('Article')['hidden_val'];
            $file_name = $model->uploadFile($file, $hid_img, $current_img);
            $model->image = $file_name;
            $model->user_id = Yii::$app->user->id;
            if (isset(Yii::$app->request->post('Article')['sub_category']) && Yii::$app->request->post('Article')['sub_category'] != null ) {
                $model->category_id = Yii::$app->request->post('Article')['sub_category'];
            }
            $model->save();

            $article->clearCurrentTags($id);

            if ( Yii::$app->request->post('tags')) {
                $tags = Yii::$app->request->post('tags');
                $model->saveTagArticle($tags,$id);
            }

            return $this->redirect(["/site/view/$id", 'article' => $model]);
        }
        }else{
            throw new BadRequestHttpException();
        }
        return $this->render('update', [
            'model' => $model, 'selectedTags' => $selectedTags, 'tags' => $tags,'items'=>$items
        ]);
    }

    public function actionDelete($id)
    {

        $article = Article::findOne($id);
        if (Yii::$app->user->id == $article->user_id){

            $image = $article['image'];
        if ($image != 'no_image.png') {
            unlink(Yii::getAlias('@common/' . 'uploads/') . $image);
        }
        $this->findModel($id)->delete();

    }else{
            throw new BadRequestHttpException();

        }
        return $this->redirect(['/user/articles']);
    }

    /**
     * Finds the Article model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Article the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Article::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionSubcategory()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $post = Yii:: $app->request->post();
        $data = array();
        $option = [];
            $option[] = "<option value=''>".Yii::t('main','select_sub_category')."</option>";
        if (Yii::$app->request->isAjax) {
            $category_id = Yii::$app->request->post('category_id');
            $category = Category::find()->where(['parent_id' => $category_id])->asArray()->all();
            if ($category) {
                foreach ($category as $items) {
                    $option[] = "<option value='$items[id]'>$items[title]</option>";
                }
                $data = ['option' => $option, 'success' => true];
            } else {
                $data = ['success' => false, 'error' => 'Error in select'];
            }
            return $data;
        }

    }


}
