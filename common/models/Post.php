<?php

namespace common\models;

use Yii;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use mohorev\file\UploadImageBehavior;
use yii\db\Expression;
use yii\helpers\StringHelper;
use yii\helpers\Url;

/**
 * This is the model class for table "post".
 *
 * @property int $id
 * @property string $title
 * @property string $content
 * @property string $resource
 * @property string $origin
 * @property int $created_at
 * @property int $updated_at
 * @property int $active
 * @property int $image
 * @property int $image_ext
 * @property int $views
 * @property string $tags
 * @property string $alias
 * @property array $categoriesIds[]
 */
class Post extends \yii\db\ActiveRecord
{
    const POPULAR = 'popular';
    const RECENT = 'recent';
    const RANDOM = 'random';
    const IMAGE_DIR = '/uploads/';

    public $categoriesIds;
    public $defaultImage = '/images/dog.png';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'post';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'content', 'resource'], 'required'],
            [['content', 'origin'], 'string'],
            [['created_at', 'updated_at', 'active', 'views'], 'integer'],
            [['title'], 'string', 'max' => 3000],
            [['alias', 'image_ext', 'resource'], 'string', 'max' => 255],
            ['image', 'file', 'extensions' => 'png, jpg, gif', 'on' => ['insert', 'update']],
            [['tags', 'categoriesIds'], 'safe']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'content' => 'Содержание',
            'resource' => 'Источник',
            'origin' => 'Origin',
            'image' => 'Изображение',
            'image_ext' => 'Ссылка на изображение',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'views' => 'Просмотры',
            'tags' => 'Теги',
            'categoriesIds' => 'Категории',
            'active' => 'Активность'
        ];
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            [
                'class' => UploadImageBehavior::class,
                'attribute' => 'image',
                'scenarios' => ['insert', 'update'],
                'path' => '@frontend/web/uploads',
                'url' => '@web/uploads',
                'placeholder' => '@frontend/web/images/dog.png',
                'thumbs' => [
                    'thumb' => ['width' => 400, 'quality' => 90],
                    'preview' => ['width' => 100, 'height' => 100],
                ],
            ],
            [
                'class' => SluggableBehavior::className(),
                'attribute' => 'title',
                'slugAttribute' => 'alias',
            ],
        ];
    }

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if (in_array($this->scenario, ['insert', 'update'])) {
            PostCategory::deleteAll(['post_id' => $this->id]);
            if (!empty($this->categoriesIds)) {
                foreach ($this->categoriesIds as $id) {
                    $model = new PostCategory();
                    $model->post_id = $this->id;
                    $model->category_id = $id;
                    $model->save(false);
                }
            }
        }

        return parent::beforeSave($insert); // TODO: Change the autogenerated stub
    }

    /**
     * @param bool $time
     * @return false|string
     */
    public function getCreated($time = false)
    {
        return $time ? date('d.m.y H:i', $this->created_at) : date('d.m.Y', $this->created_at);
    }

    /**
     * @param string $format
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    public function getCreatedText($format = 'F j, Y')
    {
        return Yii::$app->formatter->asDate($this->created_at);
    }

    /**
     * @param bool $time
     * @return false|string
     */
    public function getUpdated($time = false)
    {
        return $time ? date('d.m.y H:i', $this->updated_at) : date('d.m.Y', $this->updated_at);
    }

    /**
     * Возвращает последний пост
     *
     * @return HelperQuery
     */
    public static function getLatestQuery()
    {
        return self::find()->active()->orderBy('created_at DESC');
    }

    /**
     * Возвращает последние посты
     *
     * @param int $limit
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getLatest($limit = 6)
    {
        return self::getLatestQuery()->limit($limit)->all();
    }

    /**
     * Возвращает самые популярные посты
     *
     * @param int $limit
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getPopular($limit = 4)
    {
        return self::find()->active()->limit($limit)->orderBy('views DESC')->all();
    }

    /**
     * Возвращает query категорию по алиасу поста
     *
     * @param string $alias
     * @return HelperQuery|null
     */
    public static function getByCategoryAliasQuery($alias)
    {
        $category = Category::find()->active()->andWhere(['alias' => $alias])->one();
        if (!$category) return null;

        $postIds = PostCategory::find()->select(['post_id'])
            ->where(['category_id' => $category->id])->column();

        return self::find()->active()->filterByIds($postIds)->orderBy('created_at DESC');
    }

    /**
     * Возвращает категорию по алиасу поста
     *
     * @param string $alias
     * @param int $limit
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getByCategoryAlias($alias, $limit = 6)
    {
        return self::getByCategoryAliasQuery($alias)->limit($limit)->all();
    }

    /**
     * @return Category[]
     */
    public function getCategories()
    {
        $categoryIds = $this->getCategoriesRel()->select('category_id')->column();
        return Category::findAll(['id' => $categoryIds]);
    }

    /**
     * @return HelperQuery|\yii\db\ActiveQuery
     */
    public static function find()
    {
        return new HelperQuery(get_called_class());
    }

    /**
     * @return int|string
     */
    public function getImageUrl()
    {
        $image = self::IMAGE_DIR . $this->image;
        $imagePath = Yii::getAlias('@frontend') . '/web' .  $image;
        if (!is_file($imagePath)) {
            $image = $this->defaultImage;
        }
        return !empty($this->image_ext) ? $this->image_ext : $image;
    }

    /**
     * @param int $num
     * @return string
     */
    public function getPreviewText($num = 30)
    {
        return StringHelper::truncateWords(strip_tags($this->content), $num);
    }

    /**
     * Присваивает id категорий, используется в админке
     */
    public function setCategoryIds()
    {
        $this->categoriesIds = PostCategory::find()->select('category_id')
            ->where(['post_id' => $this->id])
            ->column();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategoriesRel()
    {
        return $this->hasMany(PostCategory::class, ['post_id' => 'id']);
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return Url::to(['/post/view', 'alias' => $this->alias]);
    }

    /**
     * Поиск по ключевому слову
     *
     * @param string $q
     * @return HelperQuery
     */
    public static function findByRequestQuery($q)
    {
        return self::find()->active()
            ->andWhere([
                'or',
                ['like', 'title', $q],
                ['like', 'content', $q]
            ]);
    }

    /**
     * Поиск по ключевому слову
     *
     * @param string $q
     * @param int $limit
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function findByRequest($q, $limit = 6)
    {
        return self::findByRequestQuery($q)->all();
    }

    /**
     * @param int $limit
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getRandomPosts($limit = 4)
    {
        return self::find()->active()->limit($limit)
            ->orderBy(new Expression('rand()'))
            ->all();
    }

    /**
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function updateViews()
    {
        $this->views += 1;
        $this->update(false);
    }

    /**
     * @param int $categoryId
     * @param int $limit
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function findPostsByCategoryId($categoryId, $limit = 3)
    {
        $postIds = PostCategory::find()->select(['post_id'])
            ->joinWith(['post'])
            ->where([
                'category_id' => $categoryId,
                Post::tableName() . '.active' => 1
            ])->orderBy('created_at DESC')->limit($limit)->column();
        return self::find()->andWhere(['id' => $postIds])->all();
    }

    /**
     * @param int $limit
     * @return array
     */
    public static function getPostsFromEachCategory($limit = 3)
    {
        $posts = [];
        $categories = Category::find()->active()->all();
        foreach ($categories as $category) {
            /** @var Category $category */
            $posts[] = [
                'category_name' => $category->name,
                'category_url' => $category->getUrl(),
                'posts' => self::findPostsByCategoryId($category->id, $limit)
            ];
        }
        return $posts;
    }

}