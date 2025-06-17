<?php

namespace app\modules\test_job\controllers;

use yii\web\Controller;

/**
 * Default controller for the `test_job` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex(): string
    {
        return $this->render('index');
    }
}
