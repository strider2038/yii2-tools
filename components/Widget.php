<?php

namespace strider2038\tools\components;

use yii\helpers\StringHelper;

/**
 * @author Igor Lazarev <strider2038@rambler.ru>
 */
class Widget extends \yii\base\Widget {
    /**
     * Widget template name
     * @var string
     */
    public $template = 'default';
    
    /**
     * @inherited
     */
    public function getViewPath() {
        $module = \Yii::$app->module;
        $path = DIRECTORY_SEPARATOR . 'widgets' . DIRECTORY_SEPARATOR . StringHelper::basename($this->className());
        return (!$module ? ('@app' . DIRECTORY_SEPARATOR . 'views') : $module->getViewPath()) . $path;
    }
}
