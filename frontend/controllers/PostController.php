<?php


namespace frontend\controllers;


use common\models\Post;
use common\models\Category;
use yii\data\Pagination;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class PostController extends Controller
{
    /**
     * @param string $alias
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionCategory($alias)
    {
        $category = $this->findCategory($alias);
        $query = Post::getByCategoryAliasQuery($alias);
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);
        $pages->defaultPageSize = 6;
        $models = $query->offset($pages->offset)->limit($pages->limit)->all();

        return $this->render('category', [
            'category' => $category,
            'models' => $models,
            'pages' => $pages,
            'popular' => Post::getPopular(),
            'recent' => Post::getLatest(4)
        ]);
    }

    /**
     * @param string $alias
     * @return string
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionView($alias)
    {
        $model = $this->findPost($alias);
        $model->updateViews();

        return $this->render('view', [
            'model' => $this->findPost($alias),
            'random' => Post::getRandomPosts(),
        ]);
    }

    /**
     * @param string $alias
     * @return array|\yii\db\ActiveRecord|null
     * @throws NotFoundHttpException
     */
    protected function findCategory($alias)
    {
        if (($model = Category::find()->active()->filterByAlias($alias)->one()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Страница не найдена.');
    }

    /**
     * Finds the Post model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $alias
     * @return Post the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findPost($alias)
    {
        if (($model = Post::find()->active()->filterByAlias($alias)->one()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Страница не найдена.');
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $query = Post::getLatestQuery();
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);
        $pages->defaultPageSize = 6;
        $models = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        return $this->render('index', [
            'models' => Post::getPostsFromEachCategory(3),
            'pages' => $pages,
            'popular' => Post::getPopular(),
            'recent' => Post::getLatest(4),
        ]);
    }

}