<?php

namespace hipanel\modules\kyc\widgets;

use hipanel\modules\kyc\models\Kyc;
use hipanel\modules\client\models\Client;
use hipanel\modules\client\models\Contact;
use hipanel\helpers\Url;
use yii\base\Widget;
use yii\helpers\Html;
use yii\web\Cookie;
use Yii;

class KYCNotification extends Widget
{
    public function run(): string
    {
        if (Yii::$app->user->can('deposit')) {
            return '';
        }

        if ($this->getCookie()) {
            return '';
        }

        $this->setCookie();
        $this->registerClientScript();

        return $this->render('KYCNotification', [
        ]);
    }

    public function registerClientScript()
    {
        $this->view->registerJs(<<<JS

(function () {
    var modal = $('#kyc-notification-modal'),
        acceptingButton = $('.kyc-notification');

    acceptingButton.click(function (event) {
        event.preventDefault();
        $(this).data('clicked', true);
        modal.modal('hide');
    })

    modal.modal('show');

})()

JS
        );
    }

    private function getCookie()
    {
        $cookies = Yii::$app->request->cookies;
        return $cookies->has('kyc-notification')
            ? $cookies->getValue('kyc-notification')
            : null
        ;
    }

    private function setCookie(): void
    {
        Yii::$app->getResponse()->getCookies()
            ->add(new Cookie([
                'name' => 'kyc-notification',
                'value' => Yii::$app->user->id,
                'expire' => time() + 60 * 60 * 24 * 7,
            ]))
        ;
    }
}
