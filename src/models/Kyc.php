<?php
/**
 * Client module for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-client
 * @package   hipanel-module-client
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2019, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\kyc\models;

use hipanel\behaviors\TaggableBehavior;
use hipanel\behaviors\CustomAttributes;
use hipanel\models\TaggableInterface;
use hipanel\modules\stock\helpers\ProfitColumns;
use yii\helpers\ArrayHelper;
use hipanel\helpers\StringHelper;
use hipanel\modules\client\models\query\ClientQuery;
use hipanel\modules\domain\models\Domain;
use hipanel\modules\finance\models\Purse;
use hipanel\modules\server\models\Server;
use hipanel\modules\finance\models\Target;
use hipanel\validators\DomainValidator;
use Yii;

/**
 * Class Client.
 *
 * @property Contact $contact the primary contact
 * @property Purse[] $purses
 * @property int $id
 * @property-read string $balance
 * @property-read string $credit
 * @property-read string $currency
 * @property-read ClientWithProfit[] $profit
 * @property-read Assignment[] $assignments
 */
class Kyc extends \hipanel\base\Model implements TaggableInterface
{
    use \hipanel\base\ModelTrait;

    public const TYPE_SELLER = 'reseller';
    public const TYPE_ADMIN = 'admin';
    public const TYPE_MANAGER = 'manager';
    public const TYPE_JUNIOR_MANAGER = 'junior-manager';
    public const TYPE_CLIENT = 'client';
    public const TYPE_OWNER = 'owner';
    public const TYPE_EMPLOYEE = 'employee';
    public const TYPE_SUPPORT = 'support';
    public const TYPE_PARTNER = 'partner';

    public const STATE_NEW = 'new';
    public const STATE_STARTED = 'started';
    public const STATE_APPROVED = 'approved';
    public const STATE_DECLINED = 'declined';
    public const STATE_FAILED = 'failed';
    public const STATE_RESUBMISSION = 'resubmission';
    public const STATE_ABANDONED = 'abandoned';
    public const STATE_REVIEW = 'review';

    public function rules()
    {
        return [
            [['id', 'seller_id', 'state_id', 'provider_id', 'contact_id', 'client_id'], 'integer'],
            [['state', 'client', 'seller', 'provider'], 'string'],
            [['id'], 'required', 'on' => 'set-verified'],
            [['kyc'], 'boolean'],
        ];
    }
}
