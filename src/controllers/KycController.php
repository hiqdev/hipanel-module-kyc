<?php declare(strict_types=1);

namespace hipanel\modules\kyc\controllers;

use Exception;
use hipanel\actions\SmartUpdateAction;
use hipanel\actions\XEditableAction;
use hipanel\base\CrudController;
use hipanel\filters\EasyAccessControl;
use hipanel\helpers\ArrayHelper;
use hipanel\modules\kyc\models\Kyc;
use RuntimeException;
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\Url;

class KycController extends CrudController
{
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            [
                'class'   => EasyAccessControl::class,
                'actions' => [
                    'set-status' => 'contact.force-verify',
                    'verify'     => 'contact.read',
                    '*'          => 'contact.read',
                ],
            ],
            [
                'class'   => VerbFilter::class,
                'actions' => [
                    'set-status' => ['post'],
                    'verify'     => ['get'],
                ],
            ],
        ]);
    }

    public function actions()
    {
        return [
            'set-status' => [
                'class'    => SmartUpdateAction::class,
                'success'  => Yii::t('hipanel:client', 'Client verification status has been changed'),
                'scenario' => 'update',
                'POST xeditable' => [
                    'class' => XEditableAction::class,
                    'collectionLoader' => static function (XEditableAction $action, array $data): void {
                        // pk is the contact id: a contact may have no KYC record yet
                        $action->collection->load(array_map(static fn(array $row): array => [
                            'contact_id' => ArrayHelper::remove($row, 'id'),
                        ] + $row, $data));
                    },
                ],
            ],
        ];
    }

    public function actionWarning()
    {
        return $this->render('warning', []);
    }

    public function actionVerify($id)
    {
        try {
            $response = Kyc::perform('prepare-info', [
                'contact_id' => $id,
                'url' => Url::to(['@client/view', 'id' => $id], true),
            ]);
            if (isset($response['url'])) {
                return $this->redirect($response['url']);
            }
            throw new RuntimeException('Failed to get KYC URL');
        } catch (Exception $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
        }

        return $this->redirect($this->request->getReferrer());
    }
}
