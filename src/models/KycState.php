<?php declare(strict_types=1);

namespace hipanel\modules\kyc\models;

use Yii;

enum KycState: string
{
    case New = 'new';
    case Started = 'started';
    case Approved = 'approved';
    case Declined = 'declined';
    case Failed = 'failed';
    case Resubmission = 'resubmission';
    case Abandoned = 'abandoned';
    case Review = 'review';
    case Manual = 'manual';

    public function label(): string
    {
        return self::getLabel($this);
    }

    public function clientLabel(): ?string
    {
        return match ($this) {
            self::New, self::Started => Yii::t('hipanel.kyc', 'In progress'),
            self::Approved => Yii::t('hipanel.kyc', 'Verified'),
            default => null,
        };
    }

    public static function getLabel(KycState $value): string
    {
        return match ($value) {
            KycState::New => Yii::t('hipanel.kyc', 'New'),
            KycState::Started => Yii::t('hipanel.kyc', 'Started'),
            KycState::Approved => Yii::t('hipanel.kyc', 'Approved'),
            KycState::Declined => Yii::t('hipanel.kyc', 'Declined'),
            KycState::Failed => Yii::t('hipanel.kyc', 'Failed'),
            KycState::Resubmission => Yii::t('hipanel.kyc', 'Resubmission'),
            KycState::Abandoned => Yii::t('hipanel.kyc', 'Abandoned'),
            KycState::Review => Yii::t('hipanel.kyc', 'Review'),
            KycState::Manual => Yii::t('hipanel.kyc', 'Manual'),
        };
    }

    public static function getOptions(): array
    {
        return [
            KycState::New->value          => KycState::New->label(),
            KycState::Started->value      => KycState::Started->label(),
            KycState::Approved->value     => KycState::Approved->label(),
            KycState::Declined->value     => KycState::Declined->label(),
            KycState::Failed->value       => KycState::Failed->label(),
            KycState::Resubmission->value => KycState::Resubmission->label(),
            KycState::Abandoned->value    => KycState::Abandoned->label(),
            KycState::Review->value       => KycState::Review->label(),
            KycState::Manual->value       => KycState::Manual->label(),
        ];
    }
}
