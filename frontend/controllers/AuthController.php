<?php
/**
 * Created by PhpStorm.
 * User: Seroj
 * Date: 23.02.2018
 * Time: 18:15
 */

namespace frontend\controllers;
use common\models\LoginForm;
use frontend\models\SignupForm;
use Yii;
use yii\web\Controller;
use common\models\Users;
class AuthController extends Controller
{

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            if(Yii::$app->user->identity->isAdmin){
               return $this->redirect(Yii::$app->urlManagerBackend->createUrl([''])) ;
            }
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }


}