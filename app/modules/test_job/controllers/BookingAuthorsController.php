<?php

namespace app\modules\test_job\controllers;

use app\modules\test_job\models\Booking;
use app\modules\test_job\models\BookingAuthors;
use yii\db\Exception;
use yii\db\StaleObjectException;
use yii\filters\AccessControl;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class BookingAuthorsController extends Controller
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
        return $this->asJson(BookingAuthors::find()->with(['author', 'booking'])->asArray()->all());
    }

    /**
     * @throws Exception
     * @throws BadRequestHttpException
     */
    public function actionCreate(): Response
    {
        $model = new BookingAuthors();
        $model->setAttributes(\Yii::$app->request->post());

        if (!$model->save()) {
            throw new BadRequestHttpException('BookingAuthors not created');
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
            throw new BadRequestHttpException('Booking not update');
        }

        $model = BookingAuthors::findOne(['id' => $params['id']]);

        if (!$model) {
            throw new NotFoundHttpException('BookingAuthors not found');
        }

        $model->setAttributes($params);

        if (!$model->save()) {
            throw new BadRequestHttpException('BookingAuthors not update');
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
            throw new BadRequestHttpException('BookingAuthors not delete');
        }

        $model = BookingAuthors::findOne(['id' => $params['id']]);

        if (!$model) {
            throw new NotFoundHttpException('BookingAuthors not found');
        }

        if (!$model->delete()) {
            throw new BadRequestHttpException('BookingAuthors not delete');
        }

        return $this->asJson(['success' => true]);
    }
}
