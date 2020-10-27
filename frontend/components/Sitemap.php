<?php
namespace frontend\components;

use common\models\Post;
use common\models\Category;

class Sitemap
{

    /**
     * Создает файл sitemap
     */
    public function generate()
    {
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->preserveWhiteSpace = true;
        $dom->formatOutput = true;

        $urlSet = $dom->createElement("urlset");
        $urlSetAttribute = $dom->createAttribute('xmlns');
        $urlSetAttribute->value = 'http://www.sitemaps.org/schemas/sitemap/0.9';
        $urlSet->appendChild($urlSetAttribute);

        $static = [''];
        foreach ($static as $item) {
            $url = \Yii::$app->urlManager->createAbsoluteUrl($item);
            $urlSet->appendChild($this->getChild($dom, $url, time()));
        }

         $categories = Category::find()->active()->all();
         foreach ($categories as $category) {
             $url = \Yii::$app->urlManager->createAbsoluteUrl($category->getUrl());
             $urlSet->appendChild($this->getChild($dom, $url, time()));
         }

         $posts = Post::find()->active()->all();
         foreach ($posts as $post) {
             $url = \Yii::$app->urlManager->createAbsoluteUrl($post->getUrl());
             $urlSet->appendChild($this->getChild($dom, $url, $post->updated_at));
         }

        $dom->appendChild($urlSet);
        file_put_contents('sitemap.xml', $dom->saveXML());
    }

    /**
     * @param \DOMDocument $dom
     * @param string $link
     * @param string $modified
     * @return \DOMElement
     */
    protected function getChild(\DOMDocument $dom, $link, $modified)
    {
        $url = $dom->createElement('url');
        $loc = $dom->createElement('loc', $link);

        $url->appendChild($loc);
        $lastMod = $dom->createElement('lastmod', $this->getModified($modified));
        $url->appendChild($lastMod);

        $freq = $dom->createElement('changefreq','weekly');
        $url->appendChild($freq);

        return $url;
    }

    /**
     * @param string $modified
     * @return false|string
     */
    protected function getModified($modified)
    {
        return !empty($modified) ? date('Y-m-d', $modified) : date('Y-m-d', time());
    }
}
