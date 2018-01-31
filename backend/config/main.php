<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'defaultRoute' => 'main',// 默认控制器
    'bootstrap' => ['log'],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend'
        ],
        'user' => [
            'identityClass' => 'common\models\sys\Manager',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
            'loginUrl' => ['site/login'],
            'idParam' => '__admin',
            'as afterLogin' => 'common\behaviors\AfterLogin',
        ],
        'session' => [
            'name' => 'advanced-backend',
            'timeout' => 7200
        ],
        /** ------ 视图替换 ------ **/
        'view' => [
            'theme' => [
                'pathMap' => [
                    // 表示@backend/views优先于@basics/backend/views
                    '@basics/backend/views' => '@backend/views',
                    '@basics/backend/modules/sys/views' => '@backend/modules/sys/views',
                    '@basics/backend/modules/wechat/views' => '@backend/modules/wechat/views'
                ],
            ],
        ],
        'log' => [
            'traceLevel' => 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['info', 'warning', 'error'],
                    'logFile' => '/data/logs/waq/back.log',
                    'logVars' => [],
                ],
            ],
        ],
        /** ------ 路由配置 ------ **/
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,  // 这个是生成路由 ?r=site/about--->/site/about
            'showScriptName' => false,
            'suffix' => '.html',// 静态
            'rules' => [

            ],
        ],
        /** ------ 错误定向页 ------ **/
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        /** ------ RBAC配置 ------ **/
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'itemTable' => '{{%sys_auth_item}}',
            'assignmentTable' => '{{%sys_auth_assignment}}',
            'itemChildTable' => '{{%sys_auth_item_child}}',
            'ruleTable' => '{{%sys_auth_rule}}',
        ],

        /** ------ 后台操作日志 ------ **/
        'actionlog' => [
            'class' => 'common\models\sys\ActionLog',
        ],
        'qr' => [
            'class' => '\Da\QrCode\Component\QrCodeComponent',
            // ... you can configure more properties of the component here
        ],

        'assetManager' => [
            'bundles' => [
                'yii\web\JqueryAsset' => [
                    'js' => [],  // 去除 jquery.js
                    'sourcePath' => null,  // 不发布资源
                ],
                'yii\bootstrap\BootstrapAsset' => [
                    'css' => [],  // 去除 bootstrap.css
                    'sourcePath' => null, // 防止在 frontend/web/asset 下生产文件
                ],
            ],
        ],
    ],
    'modules' => [
//       系统模块
        'sys' => [
            'class' => 'backend\modules\sys\Module',
        ],
//       会员模块
        'member' => [
            'class' => 'backend\modules\member\Module',
        ],
        'nurse' => [
            'class' => 'backend\modules\nurse\Module',
        ],
    ],
    'params' => $params,
];
