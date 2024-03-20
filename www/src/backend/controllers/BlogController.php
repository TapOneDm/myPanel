<?php

namespace backend\controllers;

use backend\controllers\base\BaseController;
use common\rules\AdminRule;
use Yii;
use common\models\Blog;
use common\models\BlogSearch;
use common\models\File;
use yii\db\ActiveQuery;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

class BlogController extends BaseController
{
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::class,
                    'actions' => [
                        'delete' => ['POST'],
                        'sort-image' => ['POST'],
                    ],
                ],
            ],
        );
    }

    public function actionIndex(): string
    {
        $searchModel = new BlogSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        $dataProvider->pagination->pageSize = 4;
        
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel
        ]);
    }

    public function actionCreate(): Response | string
    {
        $model = new Blog();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $tz = new \DateTimeZone(Yii::$app->params['timeZone']);
                $model->created_at = (new \DateTime())->setTimezone($tz)->format('Y-m-d H:i:s');
                $model->updated_at = (new \DateTime())->setTimezone($tz)->format('Y-m-d H:i:s');
                $model->save();

                return $this->redirect(['index']);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate(int $id): Response | string
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post())) {
            $tz = new \DateTimeZone('Europe/Minsk');
            $model->updated_at = (new \DateTime())->setTimezone($tz)->format('Y-m-d H:i:s');
            $model->save();
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete(int $id): Response
    {
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }

    protected function findModel(int $id): Blog
    {
        $model = Blog::find()->with('tags')->andWhere(['id' => $id])->one();
        if ($model !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionSortImage($id)
    {
        if (Yii::$app->request->isAjax) {
            $post = Yii::$app->request->post('sort_order');
            if ($post['oldIndex'] > $post['newIndex']) {
                $param = ['and', ['>=', 'sort_order', $post['newIndex']], ['<', 'sort_order', $post['oldIndex']]];
                $counter = 1;
            } else {
                $param = ['and', ['<=', 'sort_order', $post['newIndex']], ['>', 'sort_order', $post['oldIndex']]];
                $counter = -1;
            }
            File::updateAllCounters(['sort_order' => $counter], ['and', ['owner_model' => 'blog', 'owner_id' => $id], $param]);
            File::updateAll(['sort_order' => $post['newIndex']], ['id' => $post['stack'][$post['newIndex']]['key']]);
            return true;
        }
    }

    public function actionDeleteImage(): bool
    {
        $model = File::findOne(Yii::$app->request->post('key'));
        if ($model) {
            $model->delete();
            return true;
        } else {
            throw new NotFoundHttpException('The requested page does not exists');
        }
    }

    public function actionRole()
    {
        //        $adminRole = Yii::$app->authManager->createRole('admin');
        //        $adminRole->description = 'Администратор';
        //        Yii::$app->authManager->add($adminRole);
        //
        //        $contentManagerRole = Yii::$app->authManager->createRole('content_manager');
        //        $contentManagerRole->description = 'Контент менеджер';
        //        Yii::$app->authManager->add($contentManagerRole);
        //
        //        $userRole = Yii::$app->authManager->createRole('user');
        //        $userRole->description = 'Пользователь';
        //        Yii::$app->authManager->add($userRole);
        //
        //        $blockedUserRole = Yii::$app->authManager->createRole('user_blocked');
        //        $blockedUserRole->description = 'Заблокированный пользователь';
        //        Yii::$app->authManager->add($blockedUserRole);

        //        $adminPermission = Yii::$app->authManager->createPermission('canAdmin');
        //        $adminPermission->description = 'Право на вход в админпанель';
        //        Yii::$app->authManager->add($adminPermission);

        //        $adminRole = Yii::$app->authManager->getRole('admin');
        //        $contentManagerRole = Yii::$app->authManager->getRole('content_manager');
        //        $canAdminPermission = Yii::$app->authManager->getPermission('canAdmin');
        //        Yii::$app->authManager->addChild($adminRole, $canAdminPermission);
        //        Yii::$app->authManager->addChild($contentManagerRole, $canAdminPermission);

//        $adminRole = Yii::$app->authManager->getRole('admin');
//        $contentManager = Yii::$app->authManager->getRole('content_manager');
//        $userRole = Yii::$app->authManager->getRole('user');
//        Yii::$app->authManager->assign($userRole, 11);

//        $auth = Yii::$app->authManager;
//        $adminRule = new AdminRule();
//        $auth->add($adminRule);
//        $updateOwnEntity = $auth->createPermission('updateOwnEntity');
//        $updateOwnEntity->description = 'Edit items created by this user';
//        $updateOwnEntity->ruleName = $adminRule->name;
//        $auth->add($updateOwnEntity);
//        $updateEntity = $auth->createPermission('updateEntity');
//        $updateEntity->description = 'Edit items';
//        $updateEntity->ruleName = $adminRule->name;
//        $auth->add($updateEntity);

//        $websiteManager = $auth->createRole('website_manager');
//        $websiteManager->description = 'Website manager';
//        $auth->add($websiteManager);


//        $auth = Yii::$app->authManager;
//        $blogRule = $auth->createPermission('canBlog');
//        $blogRule->description = 'Can edit "Blogs" section';
//
//        $tagRule = $auth->createPermission('canTag');
//        $tagRule->description = 'Can edit "Tags" section';
//        $websiteRule = $auth->createPermission('canWebsite');
//        $websiteRule->description = 'Can edit "Website" sections';
//        $auth->add($blogRule);
//        $auth->add($tagRule);
//        $auth->add($websiteRule);
        return "Assigned Opa opa userRole";
    }
}
