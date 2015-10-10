<?php

namespace tuyakhov\formbuilder;

use tuyakhov\materialize\DatePicker;
use yii\base\InvalidConfigException;
use yii\base\Model;
use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\widgets\ActiveForm;

/**
 * Form Widget
 */
class Form extends Widget
{
    const TYPE_CHECKBOX = 'checkbox';
    const TYPE_RADIO = 'radio';
    const TYPE_SELECT = 'select';
    const TYPE_TEXTAREA = 'textarea';
    const TYPE_TEXT = 'text';
    const TYPE_DATEPICKER = 'datepicker';

    public static $listTypes = [
        self::TYPE_CHECKBOX => 'checkboxList',
        self::TYPE_RADIO => 'radioList',
        self::TYPE_SELECT => 'dropDownList',
        self::TYPE_TEXTAREA => 'textarea',
        self::TYPE_TEXT => 'textInput',
        self::TYPE_DATEPICKER => 'tuyakhov\materialize\DatePicker',
    ];
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
            $items = [];
            if (array_key_exists($fieldType, self::$listTypes)) {
                $fieldType = self::$listTypes[$fieldType];
                if (isset($field->choices)) {
                    $items = ArrayHelper::getColumn(Json::decode($field->choices), 'label');
                }
            }
            $options = isset($field->options) ? Json::decode($field->options) : [];
            $options['labelOptions']['label'] = $field->label;
            $formField = $this->form->field($this->model, "values[{$attributeName}][value]", $options);
            if (method_exists($formField, $fieldType)) {
                echo $formField->$fieldType($items);
            } elseif (class_exists($fieldType)) {
                echo $formField->widget($fieldType, isset($field->config) ? Json::decode($field->config) : []);
            } else {
                echo $formField->textInput($options);
            }
        }
    }


}
