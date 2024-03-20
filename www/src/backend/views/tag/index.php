<?php

use common\models\Tag;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\TagSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Tags';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tag-index crud-index">
    <p>
        <?= Html::a('Create Tag', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],

            'name',
            [
                'class' => ActionColumn::class,
                'headerOptions' => ['class' => 'actions', 'style' => 'width: 10%'],
                'filterOptions' => ['class' => 'actions', 'style' => 'width: 10%'],
                'contentOptions' => ['class' => 'actions', 'style' => 'width: 10%'],

                'buttons' => [
                    'view' => fn($url, $model) => Html::a('<i class="icon-eye"></i>', Url::to($url)),
                    'update' => fn($url, $model) => Html::a('<i class="icon-pencil"></i>', Url::to($url)),
                    'delete' => fn($url, $model) => Html::a('<i class="icon-trash"></i>', '#', [
                        'data-action' => 'delete',
                        'data-url' => $url,
                    ]),
                ],
                'visibleButtons' => [
                        'view' => false,
                ]
            ],
        ],
    'pager' => [
        'maxButtonCount' => 3,
        'options' => [
            'tag' => 'ul',
            'class' => 'pagination', //pagination-sm
        ],
        'prevPageLabel' => '<i class="icon-angle-left"></i>',
        'nextPageLabel' => '<i class="icon-angle-right"></i>',
    ],
    ]); ?>


</div>
