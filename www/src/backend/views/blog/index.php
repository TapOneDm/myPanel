<?php

use common\models\Blog;
use common\models\File;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\BlogSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Blogs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="blog-index crud-index">
    <p>
        <?= Html::a('Create Blog', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>
    <?php \yii\widgets\Pjax::begin(); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'class' => 'yii\grid\CheckboxColumn',
                'checkboxOptions' => ['style' => 'display: block;margin-right: auto;margin-left: auto; width: 50px;'],
                'header' => Html::checkBox('selection_all', false, [
                    'class' => 'select-on-check-all pull-left',
                ]),
                'headerOptions' => ['style' => 'width: 50px'],
                'filterOptions' => ['display' => 'none', 'style' => 'width: 50px'],
                'contentOptions' => ['style' => 'width: 50px'],
            ],
            [
                'label' => 'image',
                'format' => 'image',
                'value' => fn ($model) => File::getThumb($model->image, 'blog', '50x50'),
                'headerOptions' => ['style' => 'width: 100px'],
                'filterOptions' => ['display' => 'none', 'style' => 'width: 100px'],
                'contentOptions' => ['style' => 'width: 100px'],
            ],
            'title',
            [
                'label' => 'Author',
                'attribute' => 'user_id',
                'value' => fn ($model) => $model->user_id,
            ],
            [
                'label' => 'Status',
                'attribute' => 'status_id',
                'value' => fn ($model) => $model->status_id ? 'Yes' : 'No',
                'filterOptions' => ['style' => 'visibility: hidden'],
            ],
            [
                'class' => ActionColumn::class,
                'headerOptions' => ['class' => 'actions', 'style' => 'width: 10%'],
                'filterOptions' => ['class' => 'actions', 'style' => 'width: 10%'],
                'contentOptions' => ['class' => 'actions', 'style' => 'width: 10%'],

                'buttons' => [
                    'update' => fn ($url, $model) => Html::a('<i class="icon-pencil"></i>', Url::to($url)),
                    'delete' => fn ($url, $model) => Html::a('<i class="icon-trash"></i>', '#', [
                        'data-action' => 'delete',
                        'data-url' => $url,
                    ]),
                ],
                'visibleButtons' => [
                    'view' => false,
                    'update' => true,
                    'delete' => true,
                ]

            ],
        ],
        'pager' => [
            'maxButtonCount' => 3,
            'options' => [
                'tag' => 'ul',
                'class' => 'pagination',
            ],
            'prevPageLabel' => '<i class="icon-angle-left"></i>',
            'nextPageLabel' => '<i class="icon-angle-right"></i>',
        ],

    ]); ?>
    <?php \yii\widgets\Pjax::end(); ?>

</div>