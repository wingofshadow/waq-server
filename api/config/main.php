<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-api',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'api\controllers',
    'bootstrap' => ['log'],
    'components' => [
        'user' => [
            'identityClass' => 'common\models\base\AccessToken',
            'enableAutoLogin' => true,
            'enableSession' => false,// 显示一个HTTP 403 错误而不是跳转到登录界面
            'loginUrl' => null,
        ],
        'log' => [
            'traceLevel' => 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['info', 'warning', 'error'],
                    'logFile' => '/data/logs/waq/api.log',
                    'logVars' => [],
                ],
            ],
        ],
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
        ],
//        'response' => [
//            'class' => 'yii\web\Response',
//            'on beforeSend' => function ($event) {
//                $response = $event->sender;
//                $response->data = [
//                    'code' => $response->statusCode,
//                    'message' => $response->statusText,
//                    'data' => $response->data,
//                ];
//                // 格式化报错输入格式 默认为格式500状态码 其他可自行修改
//                if ($response->statusCode == 500) {
//                    if (YII_DEBUG){
//                        $exception = Yii::$app->getErrorHandler()->exception;
//                        $response->data['data'] = [
//                            'name' => ($exception instanceof Exception || $exception instanceof ErrorException) ? $exception->getName() : 'Exception',
//                            'type' => get_class($exception),
//                            'file' => $exception->getFile(),
//                            'errorMessage' => $exception->getMessage(),
//                            'line' => $exception->getLine(),
//                            'stack-trace' => explode("\n", $exception->getTraceAsString()),
//                        ];
//
//                        if ($exception instanceof Exception){
//                            $response->data['data']['error-info'] = $exception->errorInfo;
//                        }
//                    } else {
//                        $response->data['data'] = '内部服务器错误';
//                    }
//                }
//
//                $response->format = yii\web\Response::FORMAT_JSON;
//            },
//        ],
        'errorHandler' => [
            'errorAction' => 'message/error',
        ],
    ],
    'modules' => [
        // 版本1
        'v1' => [
            'class' => 'api\modules\v1\Module',
        ],
    ],
    'params' => $params,
];