<?php

namespace strider2038\tools\components;

use Yii;
use yii\log\FileTarget;
use yii\log\Logger;
use yii\helpers\VarDumper;

/**
 * File target for logging console commands
 * @author Igor Lazarev <strider2038@rambler.ru>
 */
class CommandFileTarget extends FileTarget {
    
    /**
     * @inheritdoc
     */
    public $levels = ['error', 'warning', 'info'];

    /**
     * @inheritdoc
     */
    public $categories = ['cmd'];
    
    /**
     * @inheritdoc
     */
    public $logVars = [];
    
    /**
     * Logging only useful information
     * @inheritdoc
     */
    public function formatMessage($message)
    {
        list($text, $level, $category, $timestamp) = $message;
        $level = Logger::getLevelName($level);
        if (!is_string($text)) {
            // exceptions may not be serializable if in the call stack somewhere is a Closure
            if ($text instanceof \Exception) {
                $text = (string) $text;
            } else {
                $text = VarDumper::export($text);
            }
        }

        return date('Y-m-d H:i:s', $timestamp) . " [$level] {$text}";
    }
}
