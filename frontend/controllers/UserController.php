<?php
/**
 * Created by PhpStorm.
 * User: Seroj
 * Date: 24.02.2018
 * Time: 5:51
 */

namespace frontend\controllers;
use common\models\Article;
use common\models\Category;
use yii\web\Controller;

class UserController extends Controller
{
public function actionProfile(){



   return $this->render('profile');
}
public function actionArticles(){

    $parent_categories = Category::getParent();
    $data = Article::getArticlesByUser('3');

    return $this->render('articles',['articles'=>$data['articles'],
        'pagination'=>$data['pagination'],
        'parent_categories'=>$parent_categories]);

}

}