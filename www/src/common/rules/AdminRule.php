<?php

namespace common\rules;

use yii\rbac\Rule;

class AdminRule extends Rule
{
    public $name = 'isAdmin';

    public function execute($userId, $item, $params): bool
    {
        if (isset($params['admin_id']) and ($params['admin_id'] === $userId)) {
            return true;
        }
        return false;
    }
}