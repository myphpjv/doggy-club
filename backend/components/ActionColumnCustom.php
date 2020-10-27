<?php


namespace backend\components;

use yii\grid\ActionColumn;
use yii\helpers\Html;
use Yii;

/**
 * Класс используется для вывода кнопок в GridView
 */
class ActionColumnCustom extends ActionColumn
{

    /**
     * Initializes the default button rendering callbacks.
     */
    protected function initDefaultButtons()
    {
        $this->initButton('view', 'eye-open', 'primary');
        $this->initButton('update', 'pencil', 'primary');
        $this->initButton('delete', 'trash', 'danger', [
            'data-confirm' => Yii::t('yii', 'Вы уверены, что хотите удалить этот элемент?'),
            'data-method' => 'post',
        ]);
    }

    /**
     * @param string $name
     * @param string $iconName
     * @param string $aButtonClass
     * @param array $additionalOptions
     */
    protected function initButton($name, $iconName, $aButtonClass, $additionalOptions = [])
    {
        if (!isset($this->buttons[$name]) && strpos($this->template, '{' . $name . '}') !== false) {
            $this->buttons[$name] = function ($url, $model, $key) use ($name, $iconName, $aButtonClass, $additionalOptions) {
                switch ($name) {
                    case 'view':
                        $title = Yii::t('yii', 'View');
                        break;
                    case 'update':
                        $title = Yii::t('yii', 'Update');
                        break;
                    case 'delete':
                        $title = Yii::t('yii', 'Delete');
                        break;
                    default:
                        $title = ucfirst($name);
                }
                $options = array_merge([
                    'title' => $title,
                    'aria-label' => $title,
                    'data-pjax' => '0',
                    'class' => "btn btn-icon btn-sm btn-$aButtonClass",
                ], $additionalOptions, $this->buttonOptions);
                $icon = Html::tag('i', '', ['class' => "glyphicon glyphicon-$iconName"]);
                return Html::a($icon, $url, $options);
            };
        }
    }
}