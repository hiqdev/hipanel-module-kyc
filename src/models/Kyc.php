<?php declare(strict_types=1);

namespace hipanel\modules\kyc\models;

use hipanel\base\Model;
use hipanel\base\ModelTrait;
use yii\helpers\Json;

/**
 *
 * @property-read string $stateLabel
 */
class Kyc extends Model
{
    use ModelTrait;

    public function rules()
    {
        return [
            [['id', 'state_id', 'provider_id', 'contact_id'], 'integer'],
            [['state', 'url'], 'string'],
            [['id', 'state'], 'required', 'on' => 'update'],
            [['data'], 'safe'],
        ];
    }

    public function getStatusLabel(): string
    {
        return KycState::tryFrom($this->state)->label();
    }

    public function getClientStatusLabel(): ?string
    {
        return $this->state ? KycState::tryFrom($this->state)->clientLabel() : null;
    }

    public function getSessionUrl(): ?string
    {
        $data = Json::decode($this->data);
        $url = $data['url'] ?? $this->url ?? null;

        return $url;
    }
}
