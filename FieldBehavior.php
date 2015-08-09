<?php
/**
 * @author Anton Tuyakhov <atuyakhov@gmail.com>
 */

namespace tuyakhov\formbuilder;


use yii\base\Behavior;
use yii\db\BaseActiveRecord;
use yii\helpers\Json;

class FieldBehavior extends Behavior
{
    public $typeAttribute = 'type';
    public $labelAttribute = 'label';
    public $itemsAttribute = 'items';
    public $requiredAttribute = 'required';
    public $orderAttribute = 'sort';

    public $modelAttribute = 'model';

    public function events()
    {
        return [
            BaseActiveRecord::EVENT_BEFORE_VALIDATE => 'parseJson'
        ];
    }

    protected function parseJson()
    {
        /**
         * @var $model BaseActiveRecord
         */
        $model = $this->owner;
        $formModel = Json::encode($model->getAttribute($this->modelAttribute));

    }


}