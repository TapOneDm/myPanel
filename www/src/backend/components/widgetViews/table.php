<?php
/** @var backend\components\TableWidget $widget  */
/** @var $tableData */
/** @var $columns */
/** @var $itemAttributes */


?>
<div class="table">
    <div class="table-header">
        <?php foreach ($columns as $field) { 
            switch ($field) {
                case 'image':
                    $class = 'header-item-image';
                    break;
                case 'actions':
                    $class = 'header-item-actions';
                    break;
                default:
                    $class = null;
            }    
        ?>
            <div class="table-header-item <?= $class ?>"><?= $field ?></div>
        <?php } ?>
    </div>
    <div class="table-body">
        <?php foreach ($tableData as $item) { ?>
            <div class="table-item">
                <?= $widget->getImageField($item->image) ?>
                <?= $widget->getTitleField($item->title, true, $item->url) ?>
                <?php if ($additionalColumns = $widget->getAdditionalColumns()) { ?>
                    <?php foreach ($additionalColumns as $additionalColumn) { ?>
                        <?= $widget->getField($item[$additionalColumn]) ?>
                    <?php } ?>
                <?php } ?>
                <?= $widget->getActionsField() ?>
            </div>
        <?php } ?>
    </div>
</div>
