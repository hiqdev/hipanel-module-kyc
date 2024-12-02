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

use hipanel\modules\client\widgets\ForceVerificationBlock;
use hipanel\modules\client\widgets\verification\ClientVerification;
use hipanel\modules\kyc\widgets\ForceKYCVerification;
use Yii;
use yii\base\BootstrapInterface;
use yii\base\Event;

class KYCVerificationBootstrap implements BootstrapInterface
{
    public function bootstrap($application)
    {
        Event::on(ForceVerificationBlock::class, ForceVerificationBlock::EVENT_COLLECT_WIDGETS, function ($event) {
            /** @var ForceVerificationBlock $sender */
            $sender = $event->sender;

            if (!isset($sender->contact)) {
                return;
            }

            foreach (['kyc'] as $attribute) {
                $sender->registerWidget($attribute, Yii::createObject([
                    'class' => ForceKYCVerification::class,
                    'contact' => $sender->contact,
                ]));
            }
        });
    }
}
