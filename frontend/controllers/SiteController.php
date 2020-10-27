<?php
namespace frontend\controllers;

use common\models\Post;
use frontend\components\Sitemap;
use yii\data\Pagination;
use yii\db\Expression;
use yii\helpers\Url;
use yii\web\Controller;

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
        if(isset($_REQUEST['q'])) {
            $this->redirect(Url::to(['/site/search', 'q' => $q]));
        }
        $shortQuery = strlen($q) < 3;
        if($shortQuery) {
            $query = Post::find()->andWhere(new Expression('0=1'));
        } else {
            $query = Post::findByRequestQuery($q);
        }
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);
        $pages->defaultPageSize = 6;
        $models = $query->offset($pages->offset)->limit($pages->limit)->all();

        return $this->render('/post/search', [
            'q' => $q,
            'shortQuery' => $shortQuery,
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

}
