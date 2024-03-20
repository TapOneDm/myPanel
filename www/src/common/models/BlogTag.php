<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "blog_tag".
 *
 * @property int $id
 * @property int $blog_id
 * @property int $tag_id
 *
 * @property Blog $blog
 * @property Tag $tag
 */
class BlogTag extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'blog_tag';
    }

    public function rules()
    {
        return [
            [['blog_id', 'tag_id'], 'required'],
            [['blog_id', 'tag_id'], 'default', 'value' => null],
            [['blog_id', 'tag_id'], 'integer'],
            [['blog_id'], 'exist', 'skipOnError' => true, 'targetClass' => Blog::class, 'targetAttribute' => ['blog_id' => 'id']],
            [['tag_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tag::class, 'targetAttribute' => ['tag_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'blog_id' => 'Blog ID',
            'tag_id' => 'Tag ID',
        ];
    }

    public function getBlog()
    {
        return $this->hasOne(Blog::class, ['id' => 'blog_id']);
    }

    public function getTag()
    {
        return $this->hasOne(Tag::class, ['id' => 'tag_id']);
    }
}
