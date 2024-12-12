<?php declare(strict_types=1);

namespace hipanel\modules\kyc\models;

use hipanel\base\Model;
use hipanel\base\ModelTrait;
use hipanel\models\Ref;
use yii\helpers\Json;

/**
 *
 * @property-read null|string $status
 * @property-read null|string $statusLabel
 * @property-read null|string $sessionUrl
 */
class Kyc extends Model
{
    use ModelTrait;

    const string STATE_NEW = 'new';
    const string STATE_SUBMITTED = 'submitted';
    const string STATE_WAITING_COMPLETE = 'waiting_complete';
    const string STATE_WAITING_CONTINUED = 'waiting_continued';
    const string STATE_FLOW_FINISHED = 'flow_finished';
    const string STATE_FLOW_CANCELLED = 'flow_cancelled';
    const string STATE_APPROVED = 'approved';
    const string STATE_DECLINED = 'declined';
    const string STATE_RESUBMISSION_REQUESTED = 'resubmission_requested';
    const string STATE_ABANDONED = 'abandoned';
    const string STATE_EXPIRED = 'expired';
    const string STATE_MANUAL = 'manual';
    const string STATE_REJECTED = 'rejected';


    public static function getStatusOptions(): array
    {
        return Ref::getList('state,kyc', 'hipanel.kyc');
    }

    public function rules()
    {
        return [
            [['id', 'state_id', 'provider_id', 'contact_id'], 'integer'],
            [['state', 'state_label', 'url'], 'string'],
            [['id', 'state'], 'required', 'on' => 'update'],
            [['data'], 'safe'],
        ];
    }

    public function getSessionUrl(): ?string
    {
        $data = Json::decode($this->data);

        return $data['url'] ?? $this->url ?? null;
    }

    public function getStatusLabel(): ?string
    {
        return $this->state_label;
    }

    public function needToShowButton(): bool
    {
        return empty($this->state) || !in_array($this->state, $this->isVerificationNotRequired(), true);
    }

    public function needToShowStatus(): bool
    {
        return !empty($this->state);
    }

    public function isVerificationNotRequired()
    {
        return [
            self::STATE_APPROVED => self::STATE_APPROVED,
            self::STATE_MANUAL => self::STATE_MANUAL,
            self::STATE_REJECTED => self::STATE_REJECTED,
        ];
    }
}
