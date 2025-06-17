<?php

namespace app\modules\test_job\controllers;

use app\modules\test_job\models\Subscription;
use yii\db\Exception;
use yii\db\StaleObjectException;
use yii\filters\AccessControl;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class SubscriptionController extends Controller
{
    /**
     * RBAC тут не нужен. Достаточно наличия авторизации.
     *
     * @return array[]
     */
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['index', 'create', 'delete'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['create'],
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index', 'delete'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex(): Response
    {
        return $this->asJson(
            Subscription::find()
                ->with([
                    'author',
                    'user',
                ])
                ->asArray()
                ->all()
        );
    }

    /**
     * Не имеет никакого смысла подписки неавторизованного пользователя.
     *
     * @throws Exception
     * @throws BadRequestHttpException
     * @throws \Throwable
     */
    public function actionCreate(): Response
    {
        $model = new Subscription();
        $model->setAttributes(\Yii::$app->request->post());

        $userId = \Yii::$app->getUser()->getIdentity()?->getId();
        $model->setAttribute('user_id', $userId);

        if (!$model->save()) {
            throw new BadRequestHttpException('Subscription not created');
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
            throw new BadRequestHttpException('Subscription not delete');
        }

        $model = Subscription::findOne(['id' => $params['id']]);

        if (!$model) {
            throw new NotFoundHttpException('Subscription not found');
        }

        if (!$model->delete()) {
            throw new BadRequestHttpException('Subscription not delete');
        }

        return $this->asJson(['success' => true]);
    }
}
