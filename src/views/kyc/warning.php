<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = Yii::t('hipanel', 'KYC');
$this->params['breadcrumbs'][] = $this->title;

?>

<section class="box box-widget">
    <div class="box-header">
        <h3 class="box-title text-warning">
            <i class="fa"></i> &nbsp;
            <?= Yii::t('hipanel', 'Warning') ?>
        </h3>
    </div>

    <div class="box-body">
        <div class="row">
            <div class="col-md-12">
                <p><?= Yii::t('hipanel.kyc', 'Dear customer! We apologize, but domain renewal/payment/transfer operations have been temporarily suspended for you.') ?></p>
                <p><?= Yii::t('hipanel.kyc', 'In order to restore access to payment for these services, please pass through the KYC (Know Your Customer) procedure, information about this mandatory procedure we sent to you via email earlier.') ?></p>
                <p><?= Yii::t('hipanel.kyc', 'You can find more information at the link {link}', [
                        'link' => Html::a(Url::to("/faq/faq/index#tab-05-verification%2301-account-verification", true), Url::to("/faq/faq/index#tab-05-verification#01-account-verification"))
                    ]) ?></p>
                <p><?= Yii::t('hipanel.kyc', 'If you have any questions or require assistance, you can always contact us at {mailto} or through Client Service in your account. Our support team is ready to assist you.', [
                        'mailto' => Html::mailto(Yii::$app->params['support.email']),
                    ]) ?></p>
                <p><?= Yii::t('hipanel.kyc', 'Sorry for any inconvenience caused.') ?></p>
            </div>
        </div>
    </div>
</section>

