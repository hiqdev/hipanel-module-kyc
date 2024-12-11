<?php declare(strict_types=1);

namespace hipanel\modules\kyc\widgets;

use hipanel\helpers\Url;
use hipanel\modules\kyc\models\Kyc;
use Yii;
use yii\base\Widget;
use yii\helpers\Html;

class KycVerifyButton extends Widget
{
    public ?Kyc $model = null;
    public int $contactId;

    public function run(): string
    {
        $outputParts = [];
        if ($this->model->needToShowStatus()) {
            $outputParts[] = Html::a($this->model->getStatusLabel(), $this->model->getSessionUrl(), ['target' => '_blank']);
        }
        if ($this->model->needToShowButton()) {
            $outputParts[] = Html::a(
                Yii::t('hipanel.kyc', 'Verify via KYC'),
                Url::toRoute(['@kyc/verify', 'id' => $this->contactId, 'returnUrl' => Url::to('@client/view', ['id' => $this->contactId])]),
                ['class' => 'btn btn-xs btn-warning kyc-verify-button']
            );
        }

        return Html::tag('span', implode('', $outputParts), ['class' => 'space-sm']);
    }
}
