<?php
/**
 * KYC module for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-kyc
 * @package   hipanel-module-kyc
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2017-2024, HiQDev (http://hiqdev.com/)
 */

return [
    'aliases' => [
        '@kyc' => '/kyc/kyc',
    ],
    'components' => [
        'themeManager' => [
            'pathMap' => [
                dirname(__DIR__) . '/src/views' => '$themedViewPaths',
                dirname(__DIR__) . '/src/widgets/views' => '$themedWidgetPaths',
            ],
        ],
        'i18n' => [
            'translations' => [
                'hipanel:kyc' => [
                    'class' => \yii\i18n\PhpMessageSource::class,
                    'basePath' => dirname(__DIR__) . '/src/messages',
                ],
            ],
        ],
    ],
    'modules' => [
        'kyc' => [
            'class' => \hipanel\modules\kyc\Module::class,
        ],
    ],
    'bootstrap' => [
        \hipanel\modules\kyc\bootstrap\KYCVerificationBootstrap::class,
    ],
    'container' => [
        'definitions' => [
        ],
        'singletons' => [
        ],
    ],
];
