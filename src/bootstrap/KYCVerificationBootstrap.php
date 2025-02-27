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

use hiqdev\yii2\cart\controllers\CartController;
use hipanel\modules\client\models\Client;
use yii\base\BootstrapInterface;
use yii\base\Event;
use yii\web\View;
use Yii;

class KYCVerificationBootstrap implements BootstrapInterface
{
    public function bootstrap($application)
    {
        $user = Yii::$app->user;
        if ($user->isGuest) {
            return ;
        }

        if (in_array($user->_identity->type, [Client::TYPE_SELLER, Client::TYPE_CLIENT], true)) {
            return ;
        }

        Yii::$app->view->on(View::EVENT_END_BODY, function () use ($user) {
            echo \hipanel\modules\kyc\widgets\KYCNotification::widget([
            ]);
        });

        Event::on(CartController::class, CartController::EVENT_BEFORE_ACTION, function ($event) use ($user) {
            if ($event->sender->action->id !== 'index') {
                return ;
            }
            if (!$user->isGuest && !$user->can('deposit')) {
                Yii::$app->getResponse()->redirect('@kyc/warning');
                Yii::$app->end();
            }
        });
    }
}

