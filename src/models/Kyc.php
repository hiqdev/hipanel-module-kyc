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
        return empty($this->state) || in_array($this->state, ['rejected', 'declined', 'failed'], true);
    }

    public function needToShowStatus(): bool
    {
        return !empty($this->state);
    }
}
