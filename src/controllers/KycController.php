<?php
/**
 * Client module for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-client
 * @package   hipanel-module-client
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2019, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\kyc\controllers;

use hipanel\actions\ComboSearchAction;
use hipanel\actions\IndexAction;
use hipanel\actions\RenderJsonAction;
use hipanel\actions\SmartDeleteAction;
use hipanel\actions\SmartPerformAction;
use hipanel\actions\SmartUpdateAction;
use hipanel\actions\ValidateFormAction;
use hipanel\actions\ViewAction;
use hipanel\base\CrudController;
use hipanel\filters\EasyAccessControl;
use hipanel\helpers\ArrayHelper;
use hipanel\modules\client\models\Contact;
use hipanel\modules\client\models\query\ContactQuery;
use hipanel\modules\client\models\Verification;
use hipanel\modules\client\repositories\NotifyTriesRepository;
use hipanel\modules\document\models\Document;
use Yii;
use yii\base\Event;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\helpers\Html;
use hipanel\helpers\Url;

class KycController extends CrudController
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            [
                'class' => EasyAccessControl::class,
                'actions' => [
                    'set-verified' => 'contact.force-verify',
                    '*' => 'contact.force-verify',
                ],
            ],
            [
                'class' => VerbFilter::class,
                'actions' => [
                    'set-verified' => ['post'],
                ],
            ],
        ]);
    }

    public function actions()
    {
        return [
            'set-verified' => [
                'class' => SmartPerformAction::class,
                'success' => Yii::t('hipanel:client', 'Client verification status has been changed'),
                'POST ajax' => [
                    'save' => true,
                    'flash' => true,
                    'success' => [
                        'class' => RenderJsonAction::class,
                        'return' => function ($action) {
                            $message = Yii::$app->session->removeFlash('success');

                            return [
                                'success' => true,
                                'text' => Yii::t('hipanel:client', reset($message)['text']),
                            ];
                        },
                    ],
                    'error' => [
                        'class' => RenderJsonAction::class,
                        'return' => function ($action) {
                            $message = Yii::$app->session->removeFlash('error');

                            return [
                                'success' => false,
                                'text' => reset($message)['text'],
                            ];
                        },
                    ],
                ],
            ],
        ];
    }

}
