<?php

namespace wind\oauth2\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use wind\oauth2\filters\ErrorToExceptionFilter;

class DefaultController extends \yii\rest\Controller
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
        $server = $this->module->getServer();
        $request = $this->module->getRequest();
        $response = $server->handleTokenRequest($request);
        
        return $response->getParameters();
    }
    
    public function actionRevoke()
    {
        $server = $this->module->getServer();
        $request = $this->module->getRequest();
        $response = $server->handleRevokeRequest($request);
        
        return $response->getParameters();
    }
}
