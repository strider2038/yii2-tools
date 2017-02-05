<?php

namespace strider2038\tools\components;

/**
 * @author Igor Lazarev <strider2038@rambler.ru>
 */
class Controller extends \yii\web\Controller {

    /**
     * @inherited
     */
    public function getViewPath() {
        return $this->module->getViewPath() . DIRECTORY_SEPARATOR . 'pages' . DIRECTORY_SEPARATOR . $this->id;
    }

}
