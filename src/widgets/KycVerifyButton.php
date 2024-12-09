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
        $statusLabel = $this->model ? $this->model->getClientStatusLabel() : '';
        if ($statusLabel === 'In progress') {
            return Html::a($statusLabel, $this->model->getSessionUrl(), ['target' => '_blank']);
        }

        return Html::tag('span', implode(' ', [
            $statusLabel,
            !$statusLabel ? Html::a(
                Yii::t('hipanel.kyc', 'Verify via KYC'),
                Url::toRoute(['@kyc/verify', 'id' => $this->contactId]),
                ['class' => 'btn btn-xs btn-warning kyc-verify-button']
            ) : '',
        ]), ['class' => 'space-sm']);
    }
}
