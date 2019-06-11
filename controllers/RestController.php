<?php

namespace wind\oauth2\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use wind\oauth2\filters\ErrorToExceptionFilter;

class RestController extends \yii\rest\Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'exceptionFilter' => [
                'class' => ErrorToExceptionFilter::className()
            ],
        ]);
    }
    
    public function actionToken()
    {
        $response = $this->module->getServer()->handleTokenRequest();
        return $response->getParameters();
    }
}