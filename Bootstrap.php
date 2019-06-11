<?php

namespace wind\oauth2;

use yii\web\GroupUrlRule;

class Bootstrap implements \yii\base\BootstrapInterface
{
    /**
     * @var array Model's map
     */
    private $_modelMap = [
        'OauthClients'               => 'wind\oauth2\models\OauthClients',
        'OauthAccessTokens'          => 'wind\oauth2\models\OauthAccessTokens',
        'OauthAuthorizationCodes'    => 'wind\oauth2\models\OauthAuthorizationCodes',
        'OauthRefreshTokens'         => 'wind\oauth2\models\OauthRefreshTokens',
        'OauthScopes'                => 'wind\oauth2\models\OauthScopes',
    ];
    
    /**
     * @var array Storage's map
     */
    private $_storageMap = [
        'access_token'          => 'wind\oauth2\storage\Pdo',
        'authorization_code'    => 'wind\oauth2\storage\Pdo',
        'client_credentials'    => 'wind\oauth2\storage\Pdo',
        'client'                => 'wind\oauth2\storage\Pdo',
        'refresh_token'         => 'wind\oauth2\storage\Pdo',
        'user_credentials'      => 'wind\oauth2\storage\Pdo',
        'public_key'            => 'wind\oauth2\storage\Pdo',
        'jwt_bearer'            => 'wind\oauth2\storage\Pdo',
        'scope'                 => 'wind\oauth2\storage\Pdo',
    ];
    
    /**
     * @inheritdoc
     */
    public function bootstrap($app)
    {
        $module_list = array_keys($app->getModules());
        $module_oauth = [];
        foreach ($module_list as $item) {
            if (strpos($item,'oauth')===0) {
                $module_oauth[] = $item;
            }
        }
        foreach ($module_oauth as $oauth_name) {
            /** @var $module Module */
            if ($app->hasModule($oauth_name) && ($module = $app->getModule($oauth_name)) instanceof Module) {
                $this->_modelMap = array_merge($this->_modelMap, $module->modelMap);
                foreach ($this->_modelMap as $name => $definition) {
                    \Yii::$container->set("filsh\\yii2\\oauth2server\\models\\" . $name, $definition);
                    $module->modelMap[$name] = is_array($definition) ? $definition['class'] : $definition;
                }
            
                $this->_storageMap = array_merge($this->_storageMap, $module->storageMap);
                foreach ($this->_storageMap as $name => $definition) {
                    \Yii::$container->set($name, $definition);
                    $module->storageMap[$name] = is_array($definition) ? $definition['class'] : $definition;
                }
            
                if ($app instanceof \yii\console\Application) {
                    $module->controllerNamespace = 'wind\oauth2\commands';
                }
            }
        }
    }
}