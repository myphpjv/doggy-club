<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'language' => 'ru-RU',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'defaultRoute' => 'post/index',
    'components' => [
        'request' => [
            'baseUrl' => '',
            'csrfParam' => '_csrf-frontend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'site/search/<q>/<page>' => '/site/search',
                'site/search/<q>' => '/site/search',
                'category/<alias>/<page>' => '/post/category',
                'category/<alias>' => '/post/category',
                'post/<alias>' => '/post/view',
                'posts/<page>' => '/post/index',
            ],
        ],
        'assetManager' => [
            'appendTimestamp' => true,
        ],
        'view'         => [
            'class'           => '\rmrevin\yii\minify\View',
            'enableMinify'    => !YII_DEBUG,
            'concatCss'       => true, // concatenate css
            'minifyCss'       => true, // minificate css
            'concatJs'        => true, // concatenate js
            'minifyJs'        => true, // minificate js
            'minifyOutput'    => true, // minificate result html page
            'webPath'         => '', // path alias to web base
            'basePath'        => '@frontend/web', // path alias to web base
            'minifyPath'      => '@frontend/web/minify', // path alias to save minify result
            'jsPosition'      => [\yii\web\View::POS_END], // positions of js files to be minified
            'forceCharset'    => 'UTF-8', // charset forcibly assign, otherwise will use all of the files found charset
            'expandImports'   => true, // whether to change @import on content
            'compressOptions' => ['extra' => true], // options for compress
            'compress_output' => true,
        ],
        'sphinx' => [
            'class' => 'yii\sphinx\Connection',
            'dsn' => 'mysql:host=127.0.0.1;port=9306;',
            'username' => '',
            'password' => '',
        ],
    ],
    'params' => $params,
];
