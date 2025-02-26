<?php
/**
 * Client module for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-client
 * @package   hipanel-module-client
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2019, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\kyc\bootstrap;

use yii\base\BootstrapInterface;
use hiqdev\yii2\cart\controllers\CartController;
use yii\base\Event;
use yii\web\View;
use Yii;

class KYCVerificationBootstrap implements BootstrapInterface
{
    public function bootstrap($application)
    {
        Yii::$app->view->on(View::EVENT_END_BODY, function () {
            echo \hipanel\modules\kyc\widgets\KYCNotification::widget([
            ]);
        });

        Event::on(CartController::class, CartController::EVENT_BEFORE_ACTION, function ($event) {
            if ($event->sender->action->id !== 'index') {
                return ;
            }
            $user = Yii::$app->user;
            if (!$user->isGuest && !$user->can('deposit')) {
                Yii::$app->getResponse()->redirect('@kyc/warning');
                Yii::$app->end();
            }
        });
    }
}

