<?php

use common\models\File;
use common\models\User;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\UserSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index crud-index">
    <p>
        <?= Html::a('Create User', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>

    <?php \yii\widgets\Pjax::begin(
        ['id' => 'crud-users', 'enablePushState' => false]
    ); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'class' => 'yii\grid\CheckboxColumn',
                'checkboxOptions'=>['style'=>'display: block;margin-right: auto;margin-left: auto; width: 50px;'],//center checkboxes
                'header' => Html::checkBox('selection_all', false, [
            ]),
            'headerOptions' => ['style' => 'width: 50px'],
            'filterOptions' => ['display' => 'none', 'style' => 'width: 50px'],
            'contentOptions' => ['style' => 'width: 50px'],

            ],
            [
                'label' => 'image',
                'format' => 'image',
                'value' => fn ($model) => File::getThumb($model->image, 'user', '50x50'),
                'headerOptions' => ['style' => 'width: 100px'],
                'filterOptions' => ['display' => 'none', 'style' => 'width: 100px'],
                'contentOptions' => ['style' => 'width: 100px'],
            ],
            'username',
            'email:email',
            [
                'label' => 'Status',
                'attribute' => 'status',
                'filter' => false,
                'value' => fn ($model) => $model->getStatus(),
                'contentOptions' => function($model) {
                    return ['style' => match($model->status) {
                        User::STATUS_ACTIVE => 'color: green;',
                        User::STATUS_INACTIVE => 'color: orange;',
                        User::STATUS_DELETED => 'color: red;',
                    },
                    ];
                }
            ],
            [
                'class' => ActionColumn::class,
                'headerOptions' => ['class' => 'actions', 'style' => 'width: 10%'],
                'filterOptions' => ['class' => 'actions', 'style' => 'width: 10%'],
                'contentOptions' => ['class' => 'actions', 'style' => 'width: 10%'],

                'buttons' => [
                    'update' => fn ($url, $model) => Html::a('<i class="icon-pencil"></i>', Url::to($url)), [
                        'data-pjax' => 0,
                    ],
                    'delete' => fn ($url, $model) => Html::a('<i class="icon-trash"></i>', '#', [
                        'data-action' => 'delete',
                        'data-pjax' => 0,
                        'data-url' => $url,
                    ]),
                ],
                'visibleButtons' => [
                    'view' => false,
                    'update' => true,
                    'delete' => fn ($model) => Yii::$app->user->getId() !== $model->id,
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

    <?php \yii\widgets\Pjax::end(); ?>

</div>