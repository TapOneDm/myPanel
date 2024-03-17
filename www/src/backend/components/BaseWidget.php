<?php

namespace backend\components;

use Yii;
use yii\base\Widget;

class BaseWidget extends Widget
{
    public function getViewPath(): string
    {
        return Yii::getAlias('@backend') . '/components/widgetViews';
    }
}