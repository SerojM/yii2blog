<?php

namespace backend\modules\admin;
use Yii;
use yii\filters\AccessControl;

/**
 * admin module definition class
 */
class Module extends \yii\base\Module
{

    public $controllerNamespace = 'backend\modules\admin\controllers';

    public function behaviors()
    {
        return [
            'access'    =>  [
                'class' =>  AccessControl::className(),
                'denyCallback'  =>  function($rule, $action)
                {
                    throw new \yii\web\ForbiddenHttpException();
                },
                'rules' =>  [
                    [
                        'allow' =>  true,
                        'matchCallback' =>  function($rule, $action)
                        {
                            if(!Yii::$app->user->isGuest){
                                return Yii::$app->user->identity->isAdmin;
                            }
                        }
                    ]
                ]
            ]
        ];
    }


    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }

}
