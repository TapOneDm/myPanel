<?php

namespace frontend\controllers;

use common\models\Blog;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class BlogController extends Controller
{

    public function actionIndex(): string
    {
        $blogs = Blog::find()->with('author')->andWhere(['status_id' => 1])->orderBy('sort_order');
        $dataProvider = new ActiveDataProvider([
            'query' => $blogs,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $this->render('index', ['dataProvider' => $dataProvider]);
    }

    public function actionGet($url)
    {
        $blog = Blog::find()->andWhere(['url' =>$url])->one();

        if ($blog) {
            return $this->render('one', ['blog' => $blog]);
        }

        throw new NotFoundHttpException('Нет такого блога');
    }
}