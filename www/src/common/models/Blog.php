<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

/**
 * This is the model class for table "blog".
 *
 * @property int $id
 * @property string $title
 * @property string $url
 * @property string $text
 * @property string $image
 * @property int $status_id
 * @property int|null $sort_order
 * @property int $user_id
 * @property array $related_tags
 * @property string $created_at
 * @property string $updated_at
 * @property BlogTag[] $blogTags
 */
class Blog extends \yii\db\ActiveRecord
{
    public $related_tags;
    public $file;

    public static function tableName()
    {
        return 'blog';
    }

    public function rules()
    {
        return [
            [['title', 'url', 'text'], 'required'],
            [['title', 'url', 'text'], 'string'],
            [['image'], 'string', 'max' => 100],
            [['file'], 'image'],
            [['status_id', 'sort_order'], 'default', 'value' => null],
            [['status_id', 'sort_order'], 'integer'],
            [['user_id'], 'default', 'value' => 1],
            [['related_tags', 'created_at', 'updated_at'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'url' => 'Url',
            'text' => 'Text',
            'status_id' => 'Status ID',
            'sort_order' => 'Sort Order',
            'user_id' => 'User ID',
            'related_tags' => 'Метки',
            'created_at' => 'Создано',
            'updated_at' => 'Обновлено',
            'image' => 'Изображение',
            'file' => 'Изображение',

        ];
    }

    public static function getStatusList(): array
    {
        return ['off', 'on'];
    }

    public function getStatusName(): string
    {
        return static::getStatusList()[$this->status_id];
    }

    public function getBlogTags(): ActiveQuery
    {
        return $this->hasMany(BlogTag::class, ['blog_id' => 'id']);
    }

    public function getTags(): ActiveQuery
    {
        return $this->hasMany(Tag::class, ['id' => 'tag_id'])->via('blogTags');
    }

    public function getImages(): ActiveQuery
    {
        return $this->hasMany(File::class, ['owner_id' => 'id'])
            ->andWhere(['owner_model' => static::tableName()])
            ->orderBy('sort_order');
    }

    public function getImagesLinks()
    {
        return ArrayHelper::getColumn($this->images, 'url');
    }

    public function getImagesLinksData()
    {
        return ArrayHelper::toArray($this->images, [
            File::class => [
                'caption' => 'name',
                'key' => 'id',
            ],
        ]);
    }

    public function getTagsArray(): array
    {
        return $this->getTags()->asArray()->all();
    }

    public function afterFind(): void
    {
        parent::afterFind();
        $this->related_tags = $this->tags;
    }

    public function beforeDelete(): bool
    {
        if (parent::beforeDelete()) {
            BlogTag::deleteAll(['blog_id' => $this->id]);
            return  true;
        }
        return false;
    }

    public function beforeSave($insert): bool
    {
        $this->image = !empty($this->image) ? $this->image : null;
        if ($file = UploadedFile::getInstance($this, 'file')) {
            $this->image = File::saveImage($file, $this->image, '/blog/');
        }
        return parent::beforeSave($insert);
    }

    public function afterSave($insert, $changedAttributes): void
    {
        parent::afterSave($insert, $changedAttributes);
        if (is_array($this->related_tags)) {
            $currentTags = ArrayHelper::map($this->tags, 'id', 'name');
            foreach ($this->related_tags as $item) {
                if (isset($currentTags[$item])) {
                    unset($currentTags[$item]);
                } else {
                    $this->createTag($item);
                }
            }
            BlogTag::deleteAll(['and', ['blog_id' => $this->id], ['tag_id' => array_keys($currentTags)]]);
        } else {
            BlogTag::deleteAll(['blog_id' => $this->id]);
        }
    }

    private function createTag($tagData)
    {
        if (!intval($tagData)) {
            $newTag = new Tag();
            $newTag->name = $tagData;
            $newTag->save();
            $tagId = $newTag->id;
        } else {
            $tagId = $tagData;
        }

        $model = new BlogTag();
        $model->blog_id = $this->id;
        $model->tag_id = $tagId;
        $model->save();

        return true;
    }

    public function getSmallImagePreview(): string
    {
        return str_replace('admin.', '', Url::home(true)) . 'uploads/images/blog/50x50/' . $this->image;
    }
}
