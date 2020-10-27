<?php

namespace common\models;

use yii\helpers\ArrayHelper;
use yii\behaviors\SluggableBehavior;
use yii\helpers\Url;

/**
 * This is the model class for table "category".
 *
 * @property int $id
 * @property string $name
 * @property int $active
 * @property string $alias
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['active'], 'integer'],
            [['name', 'alias'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'active' => 'Active',
        ];
    }

    /**
     * @return array|array[]
     */
    public function behaviors()
    {
        return [
            [
                'class' => SluggableBehavior::className(),
                'attribute' => 'name',
                'slugAttribute' => 'alias',
            ],
        ];
    }

    /**
     * @return HelperQuery|\yii\db\ActiveQuery
     */
    public static function find()
    {
        return new HelperQuery(get_called_class());
    }

    /**
     * @param int $active
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getCategories($active = 1)
    {
        $query = self::find()->where(['active' => $active]);
        return $query->all();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategoryPosts()
    {
        return $this->hasMany(PostCategory::class, ['category_id' => 'id']);
    }

    /**
     * Возвращает категории для админки
     *
     * @param int $active
     * @return array
     */
    public static function getCategoriesAdmin($active = 1)
    {
        $query = self::find()->select(['id', 'name'])->where(['active' => $active]);
        return ArrayHelper::map($query->asArray()->all(), 'id', 'name');
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return Url::to(['/post/category', 'alias' => $this->alias]);
    }

    /**
     * @param int $active
     * @return int|null
     */
    public function getPostsCount($active = 1)
    {
        $query = $this->getCategoryPosts()->joinWith(['post'])
            ->where([Post::tableName() . '.active' => $active]);
        return $query->count();
    }

}
