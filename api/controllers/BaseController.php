<?php
/**
 * Created by PhpStorm.
 * User: divine
 * Date: 2018/1/30
 * Time: 下午11:58
 */

namespace api\controllers;


use Yii;
use yii\web\Controller;
use yii\web\Response;

class BaseController extends Controller
{

    public function runAction($id, $params = [])
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $headers = Yii::$app->response->headers;
        $headers->add('Content-Type', 'application/json');

        try {
            $res = parent::runAction($id, $params);
            return [
                'code' => '0',
                'message' => "",
                'data' => $res,
            ];
        } catch (\Exception $e) {
            $message = $e->getMessage();
            if (empty($message)) {
                $message = '系统异常';
            }
            return [
                'code' => '1',
                'message' => $message,
            ];
        }
    }

}