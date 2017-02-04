<?php

namespace strider2038\tools\components;

use Yii;
use yii\console\ErrorHandler;

/**
 * Error handler extension for logging command errors
 * @author Igor Lazarev <strider2038@rambler.ru>
 */
class CommandErrorHandler extends ErrorHandler {
    
    /**
     * Besides rendering error to console, writing it into console command log
     * @inheritdoc
     */
    protected function renderException($exception)
    {
        parent::renderException($exception);
        
        if ($exception instanceof Exception && $exception instanceof UserException) {
            $message = $exception->getName() . ': ' . $exception->getMessage();
        } else {
            if ($exception instanceof Exception) {
                $message = "Exception ({$exception->getName()})";
            } elseif ($exception instanceof ErrorException) {
                $message = $exception->getName();
            } else {
                $message = 'Exception';
            }
            $message .= " '" . get_class($exception) . "'"
                . " with message " . "'{$exception->getMessage()}'"
                . "\n\nin " . dirname($exception->getFile()) . DIRECTORY_SEPARATOR 
                . basename($exception->getFile())
                . ':' . $exception->getLine() . "\n";
            if ($exception instanceof \yii\db\Exception && !empty($exception->errorInfo)) {
                $message .= "\n" . "Error Info:\n" . print_r($exception->errorInfo, true);
            }
            $message .= "\nStack trace:\n" . $exception->getTraceAsString();
        }
        
        // All magic is in CommandFileTarget
        Yii::error($message, 'cmd');
    }
    
}
