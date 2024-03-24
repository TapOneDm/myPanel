<?php

namespace common\models;

use Yii;
use yii\helpers\Url;
use yii\web\UploadedFile;

/**
 * This is the model class for table "file".
 *
 * @property int $id
 * @property string $name
 * @property string $owner_model
 * @property int $owner_id
 * @property string|null $alt
 * @property int $sort_order
 */
class File extends \yii\db\ActiveRecord
{
    public $attachment;

    public static function tableName()
    {
        return 'file';
    }

    public function rules()
    {
        return [
            [['name', 'owner_model', 'owner_id'], 'required'],
            [['owner_model'], 'string'],
            [['attachment'], 'image'],
            [['owner_id'], 'default', 'value' => null],
            [['owner_id', 'sort_order'], 'integer'],
            [['sort_order'], 'default', 'value' => function($model) {
                $count = File::find()->andWhere(['owner_model' => $model->owner_model])->count();
                return ($count > 0) ? $count++ : 0;
            }],
            [['name'], 'string', 'max' => 200],
            [['alt'], 'string', 'max' => 50],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'File[owner_model]' => 'Owner Model',
            'File[owner_id]' => 'Owner ID',
            'alt' => 'Alt',
            'sort_order' => 'Порядок сортировки',
        ];
    }

    public static function getThumb(string|null $image, string $modelDir, string $type)
    {
        if (!isset($image)) {
            return str_replace('admin.', '', Url::home(true)) . 'admin/static/img/placeholder.jpg';
        }
        return str_replace('admin.', '', Url::home(true)) . 'uploads/images/' . $modelDir . '/' . $type . '/' . $image;
    }

    public static function getUrl($name, $modelName): string
    {
        if (!isset($name)) {
            return '';
        }
        return str_replace('admin.', '', Url::home(true)) . 'uploads/images/' . $modelName . '/' . $name;
    }

    public static function saveImage($uploadedFile, $modelImage, $directory): string
    {
            $dir = Yii::getAlias('@images') . $directory;

            if (file_exists($dir . $modelImage)) {
                if ($modelImage) {
                    unlink($dir . $modelImage);
                }
            }

            if (file_exists($dir . '50x50/' . $modelImage)) {
                if ($modelImage) {
                    unlink($dir . '50x50/' . $modelImage);
                }
            }

            if (file_exists($dir . '800x/' . $modelImage)) {
                if ($modelImage) {
                    unlink($dir . '800x/' . $modelImage);
                }
            }

            $modelImage =  strtotime('now') . '_' . Yii::$app->getSecurity()->generateRandomString(6) . '.' . $uploadedFile->extension;
            $uploadedFile->saveAs($dir . $modelImage);
            $imagick = Yii::$app->image->load($dir . $modelImage);
            $imagick->background('#fff', 0);
            $imagick->resize('50', '50', Yii\image\drivers\Image::INVERSE);
            $imagick->crop('50', '50');
            $imagick->save($dir . '50x50/' . $modelImage, 90);

            $imagick = Yii::$app->image->load($dir . $modelImage);
            $imagick->background('#fff', 0);
            $imagick->resize('800', null, Yii\image\drivers\Image::INVERSE);
            $imagick->save($dir . '800x/' . $modelImage, 90);
            return $modelImage;
    }

    public function beforeDelete()
    {
        if (parent::beforeDelete()) {
            static::updateAllCounters(
                ['sort_order' => '-1'],
                [
                    'and',
                    [
                        'owner_model' => $this->owner_model,
                        'owner_id' => $this->owner_id
                    ],
                    [
                        '>',
                        'sort_order',
                        $this->sort_order
                    ]
                ]
            );
            return true;
        } else {
            return false;
        }
    }
}
