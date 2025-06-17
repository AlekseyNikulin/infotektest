<?php

namespace app\modules\test_job\controllers;

use app\modules\test_job\models\Authors;
use yii\db\Exception;
use yii\db\StaleObjectException;
use yii\filters\AccessControl;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class AuthorController extends Controller
{
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['index', 'create', 'update', 'delete'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['create', 'update', 'delete'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex(): Response
    {
        return $this->asJson(Authors::find()->all());
    }

    /**
     * @throws Exception
     * @throws BadRequestHttpException
     */
    public function actionCreate(): Response
    {
        $model = new Authors();
        $model->setAttributes(\Yii::$app->request->post());

        if (!$model->save()) {
            throw new BadRequestHttpException('Authors not created');
        }

        return $this->asJson($model);
    }

    /**
     * @throws Exception
     * @throws BadRequestHttpException
     * @throws NotFoundHttpException
     */
    public function actionUpdate(): Response
    {
        $params = \Yii::$app->request->post();

        if (empty($params['id'])) {
            throw new BadRequestHttpException('Author not update');
        }

        $model = Authors::findOne(['id' => $params['id']]);

        if (!$model) {
            throw new NotFoundHttpException('Author not found');
        }

        $model->setAttributes($params);

        if (!$model->save()) {
            throw new BadRequestHttpException('Author not update');
        }

        return $this->asJson($model);
    }

    /**
     * @throws \Throwable
     * @throws StaleObjectException
     * @throws NotFoundHttpException
     * @throws BadRequestHttpException
     */
    public function actionDelete(): Response
    {
        $params = \Yii::$app->request->post();

        if (empty($params['id'])) {
            throw new BadRequestHttpException('Author not delete');
        }

        $model = Authors::findOne(['id' => $params['id']]);

        if (!$model) {
            throw new NotFoundHttpException('Author not found');
        }

        if (!$model->delete()) {
            throw new BadRequestHttpException('Author not delete');
        }

        return $this->asJson(['success' => true]);
    }
}
