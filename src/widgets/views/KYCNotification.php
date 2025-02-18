<?php

use hipanel\modules\client\models\Contact;
use yii\bootstrap\Html;

/**
 * @var \yii\web\View
 * @var Contact $model
 * @var \yii\bootstrap\ActiveForm $form
 */
?>

<?php \yii\bootstrap\Modal::begin([
    'id' => 'kyc-notification-modal',
    'header' => '<h4>KYC</h4>',
    'size' => \yii\bootstrap\Modal::SIZE_DEFAULT,
]) ?>

<p>
    Your account functionality is currently limited due to a missing KYC status. To apply for KYC, please visit the customer’s profile page or create a support request.
</p>

<?= Html::button(Yii::t('hipanel', 'OK'),
    ['class' => 'btn btn-success kyc-notification']); ?>

<?php \yii\bootstrap\Modal::end() ?>
