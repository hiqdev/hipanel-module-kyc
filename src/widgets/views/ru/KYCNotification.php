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
    Функциональность вашего аккаунта ограничена, из-за отсутствия KYC. Чтобы пройти KYC, перейдите на страницу профиля клиента или создайте запрос в службу поддержки
</p>

<?= Html::button(Yii::t('hipanel', 'OK'),
    ['class' => 'btn btn-success kyc-notification']); ?>

<?php \yii\bootstrap\Modal::end() ?>
