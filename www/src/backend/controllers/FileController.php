<?php

namespace backend\controllers;

use backend\controllers\base\BaseController;
use Yii;
use yii\web\Response;

class FileController extends BaseController
{

    public function actionClearModelFileField()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $data = Yii::$app->request->post();

        if (empty($data['model_id'])) {
            return ['result' => true]; 
        }

        $modelId = $data['model_id'];
        $fileField = $data['file_field'];
        $modelTable = $data['model_table'];

        Yii::$app->db->createCommand("
            update $modelTable set $fileField = null where id = $modelId
        ",
        )->execute();
        return ['result' => true];

    }
}