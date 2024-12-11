<?php declare(strict_types=1);

namespace hipanel\modules\kyc\grid;

use hipanel\grid\DataColumn;
use hipanel\helpers\Url;
use hipanel\modules\client\models\Client;
use hipanel\modules\client\models\Contact;
use hipanel\modules\kyc\models\Kyc;
use hipanel\modules\kyc\widgets\KycVerifyButton;
use hiqdev\xeditable\widgets\XEditable;
use Yii;
use yii\helpers\Html;

class KycColumn extends DataColumn
{
    public $attribute = 'contact.kyc.state';
    public $format = 'raw';
    public $filterAttribute = 'kyc_status';
    public $filterOptions = ['class' => 'narrow-filter'];

    public function init(): void
    {
        parent::init();
        $this->label = Yii::t('hipanel:client', 'KYC status');
        $this->visible = Yii::getAlias("@kyc", false) !== false;
        $this->filter = $this->isAdvancedAccess() ? fn($column, $model, $attribute): string => Html::activeDropDownList(
            $model,
            $attribute,
            Kyc::getStatusOptions(),
            [
                'prompt' => '--',
                'class' => 'form-control',
            ]
        ) : false;
    }

    public function getDataCellValue($model, $key, $index)
    {
        $kyc = $this->getKycModel($model);
        if ($this->isAdvancedAccess()) {
            return XEditable::widget([
                'model' => $kyc,
                'attribute' => 'state',
                'pluginOptions' => [
                    'url' => Url::toRoute(['@kyc/set-status']),
                    'type' => 'select',
                    'source' => $kyc->getStatusOptions(),
                ],
            ]);
        }

        return KycVerifyButton::widget(['model' => $kyc, 'contactId' => $model->id]);
    }

    private function isAdvancedAccess(): bool
    {
        return Yii::$app->user->can('contact.force-verify');
    }

    private function getKycModel($model): ?Kyc
    {
        return match (true) {
            $model instanceof Client => $model->contact->kyc,
            $model instanceof Contact => $model->kyc,
            default => null,
        };
    }
}
