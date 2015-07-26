<?php

namespace tuyakhov\formbuilder;

use yii\base\InvalidConfigException;
use yii\base\Model;
use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

/**
 * Form Widget
 */
class Form extends Widget
{
    /**
     * @var $form ActiveForm
     */
    public $form;
    /**
     * @var $model Model
     */
    public $model;
    /**
     * @var $fields array
     */
    public $fields;

    /**
     * @inheritdoc
     * @throws InvalidConfigException
     */
    public function init()
    {
        foreach (['form', 'model', 'fields'] as $attribute) {
            if ($this->$attribute === null) {
                throw new InvalidConfigException(self::className() . '::' . $attribute . ' should be set');
            }
        }
        if (!$this->form instanceof ActiveForm) {
            throw new InvalidConfigException(self::className() . '::form' . ' should be instance of ' . ActiveForm::className());
        }
        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        foreach ($this->fields as $attributeName => $field) {
            $fieldType = ArrayHelper::getValue($field, 'type', null);
            $formField = $this->form->field($this->model, $attributeName, ArrayHelper::getValue($field, 'options', []));
            if (method_exists($formField, $fieldType)) {
                echo $formField->$fieldType;
            } elseif (class_exists($fieldType)) {
                echo $formField->widget($fieldType, ArrayHelper::getValue($field, 'config', []));
            }
        }
    }


}
