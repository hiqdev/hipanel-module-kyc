<?php
/**
 * Client module for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-client
 * @package   hipanel-module-client
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2019, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\kyc\widgets;

use hipanel\helpers\Url;
use hipanel\modules\client\models\Contact;
use hipanel\modules\client\widgets\verification\ForceVerificationWidgetInterface;
use hiqdev\bootstrap_switch\AjaxBootstrapSwitch;
use Yii;
use yii\base\Widget;

/**
 * Class VdsOrderVerification.
 */
class ForceKYCVerification extends Widget implements ForceVerificationWidgetInterface
{
    /**
     * @var Contact
     */
    public $contact;

    /**
     * @return string
     */
    public function getLabel()
    {
        return Yii::t('hipanel:client', 'Is 2 verified');
    }

    /**
     * @return string
     */
    public function getWidget()
    {
        return AjaxBootstrapSwitch::widget([
            'model' => $this->contact,
            'attribute' => 'kyc',
            'url' => Url::to('@kyc/set-verified'),
            'inlineLabel' => false,
            'options' => [
                'label' => false,
            ],
            'pluginOptions' => [
                'onColor' => 'success',
                'offText' => Yii::t('hipanel:client', 'NO'),
                'onText' => Yii::t('hipanel:client', 'YES'),
            ],
        ]);
    }

    /**
     * @return bool
     */
    public function canBeRendered()
    {
        return true;
    }
}
