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

class BookingController extends Controller
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
                'only' => ['index', 'create', 'update', 'delete', 'state'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'state'],
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
        return $this->asJson(Booking::find()->with(['authors'])->asArray()->all());
    }

    /**
     * @throws Exception
     * @throws BadRequestHttpException
     */
    public function actionCreate(): Response
    {
        $request = \Yii::$app->request;
        $model = new Booking();
        $model->setAttributes($request->post());

        if (!$model->save()) {
            throw new BadRequestHttpException('Booking not created');
        }

        foreach ($request->post('authors', []) as $author) {
            $junction = new BookingAuthors();
            $junction->setAttributes([
                'booking_id' => $model->getId(),
                'author_id' => $author['id'] ?? null,
            ]);
            $junction->save();
        }

        return $this->asJson(
            Booking::find()
                ->where(['id' => $model->getId()])
                ->with(['authors'])
                ->asArray()
                ->one()
        );
    }

    /**
     * @throws Exception
     * @throws BadRequestHttpException
     * @throws NotFoundHttpException
     */
    public function actionUpdate(): Response
    {
        $request = \Yii::$app->request;
        $params = $request->post();

        if (empty($params['id'])) {
            throw new BadRequestHttpException('Booking not update');
        }

        $model = Booking::findOne(['id' => $params['id']]);

        if (!$model) {
            throw new NotFoundHttpException('Booking not found');
        }

        $model->setAttributes($params);

        if (!$model->save()) {
            throw new BadRequestHttpException('Booking not update');
        }

        $authors = $request->post('authors', []);

        if ($authors) {
            BookingAuthors::deleteAll(['booking_id' => $model->getId()]);
        }

        foreach ($authors as $author) {
            $junction = new BookingAuthors();
            $junction->setAttributes([
                'booking_id' => $model->getId(),
                'author_id' => $author['id'] ?? null,
            ]);
            $junction->save();
        }

        return $this->asJson(
            Booking::find()
                ->where(['id' => $model->getId()])
                ->with(['authors'])
                ->asArray()
                ->one()
        );
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
            throw new BadRequestHttpException('Booking not delete');
        }

        $model = Booking::findOne(['id' => $params['id']]);

        if (!$model) {
            throw new NotFoundHttpException('Booking not found');
        }

        if (!$model->delete()) {
            throw new BadRequestHttpException('Booking not delete');
        }

        return $this->asJson(['success' => true]);
    }

    public function actionState(): Response
    {
        $year = (\Yii::$app->request->params['year'] ?? null) ?: '2010';

        return $this->asJson(
            Booking::getDb()->createCommand(
                sql: /** @lang text */ '
                        SELECT 
                            ba.author_id,
                            a.name AS author_name,
                            count(ba.author_id) AS quantity	 
                        FROM `booking` AS b 
                        INNER JOIN booking_authors AS ba ON ba.booking_id = b.id
                        INNER JOIN `authors` AS a ON a.id = ba.author_id
                        WHERE b.year = :year 
                        GROUP BY ba.author_id
                        ORDER BY quantity DESC
                        LIMIT 10
                ',
                params: [
                    'year' => $year,
                ],
            )->queryAll()
        );
    }
}
