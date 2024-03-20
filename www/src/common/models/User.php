<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\web\IdentityInterface;
use yii\web\UploadedFile;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $verification_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string image
 * @property string $password
 */
class User extends ActiveRecord implements IdentityInterface
{

    public $file;
    public $passwd;
    public $newPasswd;
    public $confirmPasswd;

    public $permissions;

    const STATUS_DELETED = 0;
    const STATUS_INACTIVE = 9;
    const STATUS_ACTIVE = 10;

    const CAN_BLOG_PERMISSION = 'canBlog';
    const CAN_TAG_PERMISSION = 'canTag';
    const CAN_WEBSITE_PERMISSION = 'canWebsite';

    public static function tableName()
    {
        return '{{%user}}';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    public function rules()
    {
        return [
            [['username', 'email', 'passwd', 'newPasswd', 'confirmPasswd'], 'string'],
            [['username', 'email', 'permissions'], 'required'],
            ['username', 'unique', 'message' => 'User with this username is already exists'],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE, self::STATUS_DELETED]],
            [['passwd', 'newPasswd', 'confirmPasswd'], 'string', 'max' => 255],
            [
                'confirmPasswd',
                'compare',
                'compareAttribute' => 'newPasswd',
                'operator' => '==',
                'message' => 'Input same password please'
            ],
            [['image'], 'string', 'max' => 100],
            [['file'], 'image'],
        ];
    }

    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    public static function findByVerificationToken($token) {
        return static::findOne([
            'verification_token' => $token,
            'status' => self::STATUS_INACTIVE
        ]);
    }

    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    public function getId()
    {
        return $this->getPrimaryKey();
    }

    public function getAuthKey()
    {
        return $this->auth_key;
    }

    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    public function generateEmailVerificationToken()
    {
        $this->verification_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    public static function getPasswordPlaceholder($action)
    {

        return $action === 'create' ? '' : '1234567891234567'; 
    }

    public static function getName($id)
    {
        return static::find()->select(['username'])->where(['id' => $id])->one()->username;
    }

    public function beforeSave($insert): bool
    {
        $this->image = !empty($this->image) ? $this->image : null;
        if ($file = UploadedFile::getInstance($this, 'file')) {
            $this->image = File::saveImage($file, $this->image, '/user/');
        }
        return parent::beforeSave($insert);
    }

    public function assignPermission($user_id, $permissionName)
    {
        $newAssignment = new AuthAssignment();
        $newAssignment->user_id = $user_id;
        $newAssignment->item_name = $permissionName;
        $newAssignment->save(false);
    }

    public function setPermissions($id)
    {
        $currentPermissions = [];
        foreach ($this->findOne($id)->authAssignment as $assignment) {
            $currentPermissions[] = $assignment->item_name;
        }

        $currentPermissions = array_combine(array_values($currentPermissions), array_values($currentPermissions));

        if (is_array($this->permissions)) {
            foreach ($this->permissions as $item) {
                if (isset($currentPermissions[$item])) {
                    unset($currentPermissions[$item]);
                } else {
                    $this->assignPermission($id, $item);
                }
            }
            AuthAssignment::deleteAll(['and', ['user_id' => $id], ['item_name' => array_keys($currentPermissions)]]);
        } else {
            AuthAssignment::deleteAll(['user_id' => $id]);
        }
    }

    public function afterFind(): void
    {
        parent::afterFind();
        $this->permissions = $this->authAssignment;
    }

    public function getUserPermissions()
    {
        return $this->permissions ? ArrayHelper::map($this->permissions, 'item_name', 'item_name') : null;
    }
    public function getPermissionsList()
    {
        $items = AuthItem::find()->where(['type' => 2])->asArray()->all();
        return ArrayHelper::map($items, 'name', 'name');
    }

    public function getAuthAssignment()
    {
        return $this->hasMany(AuthAssignment::class, ['user_id' => 'id']);
    }
}
