<?php

namespace strider2038\tools\components;

use Yii;
use yii\console\Controller;
use strider2038\tools\helpers\Format;

/**
 * Base class for console command controllers with automatic error logging
 * 
 * To use it simply put this lines in your config for console application
 * 
 * 'components' => [
 *      'log' => [
 *          ...
 *          'targets' => [
 *              ...
 *              // common log for all console commands
 *              'cmd' => [
 *                  'class' => 'strider2038\tools\components\CommandFileTarget',
 *              ],
 *              ...
 *          ],
 *      ],
 *      'errorHandler' => [
 *          'class' => 'strider2038\tools\components\CommandErrorHandler',
 *      ],
 *      ...
 *  ],
 *
 * @author Igor Lazarev <strider2038@rambler.ru>
 */
class CommandController extends Controller {
    
    /**
     * Execution start time of console command
     * @var float
     */
    protected $startedAt = null;
    
    /**
     * Logging execution start time
     * @inheritdoc
     */
    public function beforeAction($action) {
        if (!Yii::$app->request->isConsoleRequest || !parent::beforeAction($action)) {
            return false;
        }
        
        $this->startedAt = microtime(true);
        $targets = Yii::$app->log->targets;
        if (isset($targets['cmd'])) {
            $targets['cmd']->logFile = Yii::getAlias("@runtime/logs/cmd/{$this->id}_{$this->action->id}.log");
        }
        Yii::info("{$this->id}/{$this->action->id} has started.", 'cmd');
        
        return true;
    }
    
    /**
     * Logging execution end time and some statistics
     * @inheritdoc
     */
    public function afterAction($action, $result) {
        $eventResult = parent::afterAction($action, $result);
        
        $report = "{$this->id}/{$this->action->id} has finished." . PHP_EOL;
        $report .= 'Execution time: ' . (microtime(true) - $this->startedAt) . ' s' . PHP_EOL;
        $report .= 'Memory peak usage: ' . Format::bytes(memory_get_peak_usage(true));
        
        Yii::info($report, 'cmd');
        
        return $eventResult;
    }
}
