<?php

namespace wind\oauth2\filters\auth;

use \Yii;

class CompositeAuth extends \yii\filters\auth\CompositeAuth
{
    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        $server = Yii::$app->getModule('oauth2')->getServer();
        $server->verifyResourceRequest();
        
        return parent::beforeAction($action);
    }
}