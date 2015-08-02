<?php
/**
 * @author Anton Tuyakhov <atuyakhov@gmail.com>
 */

namespace tuyakhov\formbuilder;


use yii\base\Model;

class Field extends Model
{
    public $type;

    public $items;

    public $config;

    public $options;

    public function rules()
    {
        return [
            ['type', 'string'],
            [['options', 'config', 'items'], 'safe'],
        ];
    }


}