<?php

namespace backend\controllers;

use backend\controllers\base\BaseController;
use common\models\Blog;
use common\models\User;

use common\models\File;
use common\models\LoginForm;
use Yii;
use yii\base\DynamicModel;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\FileHelper;
use yii\helpers\Url;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\Response;
use yii\web\UploadedFile;

class SiteController extends BaseController
{
    
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['login', 'logout', 'save-wysiwyg-image', 'save-image', 'user'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['login'],
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['save-wysiwyg-image', 'save-image', 'login', 'logout', 'error'],
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    // 'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => \yii\web\ErrorAction::class,
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionSaveWysiwygImage($folder = 'main'): array
    {
        $this->enableCsrfValidation = false;
        if (Yii::$app->request->isPost) {
            $dir = Yii::getAlias('@images') . '/' . $folder .'/';

            if (!file_exists($dir)) {
                FileHelper::createDirectory($dir);
            }

            $result_link = str_replace('admin.', '', Url::home(true)) . 'uploads/images/' . $folder . '/';
            $file = UploadedFile::getInstanceByName('file');
            $model = new DynamicModel(compact('file'));
            $model->addRule('file', 'image')->validate();

            if ($model->hasErrors()) {
                $result = [
                    'error' => $model->getFirstError('file')
                ];
            } else {
                $model->file->name = strtotime('now') . '_' . Yii::$app->getSecurity()->generateRandomString(6) . '.' . $model->file->extension;

                if ($model->file->saveAs($dir . $model->file->name)) {
                    $imag = Yii::$app->image->load($dir . $model->file->name);
                    $imag->resize(800, NULL, Yii\image\drivers\Image::PRECISE)-> save($dir . $model->file->name, 85);
                    $result = ['filelink' => $result_link . $model->file->name, 'filename' => $model->file->name];
                } else {
                    $result = [
                        'error' => 'Cannot upload file'
                    ];
                }
            }
            Yii::$app->response->format = Response::FORMAT_JSON;
            return $result;
        } else {
            throw new BadRequestHttpException('Only POST is allowed');
        }
    }

    public function actionSaveImage(): array
    {
        $this->enableCsrfValidation = false;
        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            $dir = Yii::getAlias('@images') . '/' . $post['owner_model'] .'/';

            if (!file_exists($dir)) {
                FileHelper::createDirectory($dir);
            }

            $result_link = str_replace('admin.', '', Url::home(true)) . 'uploads/images/' . $post['owner_model'] . '/';
            $file = UploadedFile::getInstanceByName('File[attachment]');
            $model = new File();
            $model->name = strtotime('now') . '_' . Yii::$app->getSecurity()->generateRandomString(6) . '.' . substr($file->name, -3);
            $model->owner_model = $post['owner_model'];
            $model->owner_id = $post['owner_id'];
            $model->validate();

            if ($model->hasErrors()) {
                $result = [
                    'error' => $model->getFirstError('file')
                ];
            } else {

                if ($file->saveAs($dir . $model->name)) {
                    $imag = Yii::$app->image->load($dir . $model->name);
                    $imag->resize(800, NULL, Yii\image\drivers\Image::PRECISE)-> save($dir . $model->name, 85);
                    $result = ['filelink' => $result_link . $model->name, 'filename' => $model->name];
                } else {
                    $result = [
                        'error' => 'Ошибка'
                    ];
                }
                $model->save();
            }
            Yii::$app->response->format = Response::FORMAT_JSON;
            return $result;
        } else {
            throw new BadRequestHttpException('Only POST is allowed');
        }
    }

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->redirect('index');
        }

        $model = new LoginForm();

        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post()) && $model->login()) {
                return $this->redirect('index');
            } else {
                return $this->renderAjax('../layouts/_auth-form', [
                    'model' => $model,
                ]);
            }
        }

        return $this->render('../layouts/auth');
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->redirect(['site/login']);
    }

    public function actionError()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $exception = Yii::$app->errorHandler->exception;

        if ($exception !== null) {
//            return $this->render('error', ['exception' => $exception]);
        }
        return ['error' => true];
    }

    // public function actionUser()
    // {
    //     \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

    //     $model = new User();
    //     $model->username = 'Admin';
    //     $model->email = 'admin@gmail.com';
    //     $model->setPassword('diman1243');
    //     $model->auth_key = '';
    //     $model->permissions = ['123'];
    //     $model->status = User::STATUS_ACTIVE;
    //     if ($model->save()) {
    //         return 'yes';
    //     }
    //     return $model->getFirstErrors();
    // }
}
