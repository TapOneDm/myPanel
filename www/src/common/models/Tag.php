<?php

namespace common\models;

use Yii;

/**
 * @property int $id
 * @property string $name
 *
 * @property BlogTag[] $blogTags
 */
class Tag extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'tag';
    }

    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 50],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }

    public function beforeDelete(): bool
    {
        if (parent::beforeDelete()) {
            BlogTag::deleteAll(['tag_id' => $this->id]);
            return  true;
        }
        return false;
    }

    public function getBlogTags()
    {
        return $this->hasMany(BlogTag::class, ['tag_id' => 'id']);
    }
}
