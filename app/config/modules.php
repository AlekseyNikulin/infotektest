<?php

use yii\base\Module;

$dir = scandir(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'modules', SCANDIR_SORT_NONE);
$modules = [];

foreach ($dir as $item) {
    if (is_dir(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . $item) && $item != '.' && $item != '..') {
        /**
         * @var $moduleClass Module
         */
        $moduleClass = '\app\modules\\' . $item . '\Module';
        $modules[$item] = [
            'class' => $moduleClass,
        ];
    }
}
$modulesNames = array_keys($modules);

return $modules;