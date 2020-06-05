yii2-oauth2-server
==================
* bug修复
* 修改pdo连接文件，connection参数改为可动态配置
```php
'oauth2' => [
    'class' => '\wind\oauth2\Module',
    'db' => 'rbac_db'//oauth专属db
]
```