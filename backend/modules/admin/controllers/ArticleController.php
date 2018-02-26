<?php

namespace backend\modules\admin\controllers;

use common\models\ArticleTag;
use common\models\Category;
use common\models\Tag;
use Yii;
use common\models\Article;
use common\models\ArticleSearch;
use yii\helpers\ArrayHelper;
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
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Article models.
     * @return mixed
     */
    public function actionIndex()
    {

        $searchModel = new ArticleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Article model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
//        $category = Category::find()->where(['id'=>])
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /*
     * Creates a new Article model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
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
            $model->status = 10;
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

            return $this->redirect(['view', 'id' => $model->id]);
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

            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model, 'selectedTags' => $selectedTags, 'tags' => $tags,'items'=>$items
        ]);
    }

    public function actionDelete($id)
    {
        $article = Article::findOne($id);
        $image = $article['image'];
        if($image != 'no_image.png'){
            unlink(Yii::getAlias('@common/' . 'uploads/').$image);
        }
        $this->findModel($id)->delete();


        return $this->redirect(['index']);
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
        $option[] = "<option value=''>Choose</option>";
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
    public function actionConfirm(){

        $data = Article::getArticlesByStatus('3');

        return $this->render('confirm',['articles'=>$data['articles'],
            'pagination'=>$data['pagination']]);
    }

    public function actionConfirmArticle(){

        if (Yii::$app->request->isAjax){
            $id = Yii::$app->request->post('id');

            $model = Article::findOne($id);
            $model->status = 10;
            $model->save(false);
            $data = ['success' => true] ;
            \Yii::$app->response->format = Response::FORMAT_JSON;
            return $data;

        }

    }
    public function actionDeleteArticle(){

        if (Yii::$app->request->isAjax){
            $id = Yii::$app->request->post('id');

            $model = Article::findOne($id);
            $model->delete();
            $data = ['success' => true] ;
            \Yii::$app->response->format = Response::FORMAT_JSON;
            return $data;

        }

    }

}
