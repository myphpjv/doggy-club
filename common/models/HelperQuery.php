<?php


namespace common\models;


use yii\db\ActiveQuery;

/**
 * Общий сервисный класс для всех моделей для работы с запросами
 *
 * @return HelperQuery
 */
class HelperQuery extends ActiveQuery
{
    /**
     * @return HelperQuery
     */
    public function active()
    {
        return $this->andWhere(['active' => 1]);
    }

    /**
     * @param string $alias
     * @return HelperQuery
     */
    public function filterByAlias($alias)
    {
        return $this->andWhere(['alias' => $alias]);
    }

    /**
     * @param array $ids
     * @return HelperQuery
     */
    public function filterByIds($ids)
    {
        return $this->andWhere(['id' => $ids]);
    }
}