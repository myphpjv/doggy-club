<?php


namespace frontend\widgets;


use common\models\Post;
use yii\base\Widget;

class RightSidebar extends Widget
{
    public $postsType;
    public $postsTitle;
    public $models;

    public function run()
    {
        if($this->postsType == Post::POPULAR) {
            $this->models = Post::getPopular();
        }
        if($this->postsType == Post::RECENT) {
            $this->models = Post::getLatest(4);
        }
        if($this->postsType == Post::RANDOM) {
            $this->models = Post::getRandomPosts(4);
        }
        return $this->render('right_sidebar', [
            'models' => $this->models,
            'postsTitle' => $this->postsTitle
        ]);
    }
}