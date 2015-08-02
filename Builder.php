<?php
/**
 * @author Anton Tuyakhov <atuyakhov@gmail.com>
 */

namespace tuyakhov\formbuilder;


use yii\base\Model;
use yii\base\Widget;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

class Builder extends  Widget
{
    /**
     * @var $form ActiveForm
     */
    public $form;

    public function renderFieldForm($type, $config)
    {
        $fieldModel = \Yii::createObject($type, $config);
        if (isset($fieldModel) && $fieldModel instanceof Model) {
            foreach ($fieldModel->attributes() as $attribute) {
                $this->form->field($fieldModel, $attribute);
            }
        } else {
            return '';
        }
    }

    public function renderAddFieldButton($options)
    {
        if (empty($options['id'])) {
            $options['id'] = 'add-form-field';
        }
        return Html::a('Add field', '#', $options);
    }
}