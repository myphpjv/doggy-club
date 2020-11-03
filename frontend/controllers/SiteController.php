<?php

namespace frontend\controllers;

use common\models\Post;
use frontend\components\Sitemap;
use yii\data\Pagination;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\sphinx\Query;
use yii\web\Controller;
use TelegramBot\Api\Exception;
use TelegramBot\Api\Client;

/**
 * Site controller
 */
class SiteController extends Controller
{

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * @param string|null $q
     * @return string
     */
    public function actionSearch($q = null)
    {
        $q = trim($q);
        if (isset($_REQUEST['q'])) {
            $this->redirect(Url::to(['/site/search', 'q' => $q]));
        }

        $query  = Post::findByKeywordQuery($q);
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);
        $pages->defaultPageSize = 6;
        $models = $query->offset($pages->offset)->limit($pages->limit)->all();

        return $this->render('/post/search', [
            'q' => $q,
            'models' => $models,
            'pages' => $pages,
            'popular' => Post::getPopular(),
            'recent' => Post::getLatest(4)
        ]);
    }

    /**
     * Создает sitemap
     */
    public function actionSitemap()
    {
        $siteMap = new Sitemap();
        $siteMap->generate();
    }

    public function actionBot()
    {
        try {
            $bot = new Client(\Yii::$app->params['botApiToken']);
            $bot->command('start', function ($message) use ($bot) {
                $bot->sendMessage($message->getChat()->getId(), 'Welcome!');
            });
            $bot->run();
        } catch (Exception $e) {
            \Yii::info($e->getMessage());
        }
    }

}
