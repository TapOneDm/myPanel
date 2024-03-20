<?php

namespace backend\components;

use common\models\File;
use Yii;
use yii\helpers\Html;
use yii\helpers\Url;

class TableWidget extends BaseWidget
{
    public $modelName;
    public $tableData;
    public $columns;

    public $additionalColumns;

    public function init(): void
    {
        parent::init();
    }

    public function run(): string
    {
        return $this->render('table', [
            'tableData' => $this->tableData,
            'columns' => $this->columns,
            'widget' => $this
        ]);
    }

    public function getField($data): string
    {
        return "<div>$data</div>";
    }

    public function getImageField($src): string
    {
        $file = new File();
        $imageLink = $file->getUrl($src, $this->modelName);
        return "<div class='item-cell item-image'><img src='$imageLink' alt=''></div>";
    }

    public function getTitleField($title, $isUrl = false, $url = null): string
    {
        if ($isUrl) {
            return "<div class='item-cell item-title'>" . Html::a($title, $url) . "</div>";
        }
        return "<div class='item-cell item-title'>" . $title . "</div>";
    }

    public function getActionsField(): string
    {
        return "<div class='item-cell item-actions'><i class='fa-eye'>z</i><i class='fa-pencil'>x</i><i class='fa-trash'>c</i></div>";
    }

    public function getAdditionalColumns()
    {
        if (!empty($this->additionalColumns)) {
            return $this->additionalColumns;
        }
    }
}


