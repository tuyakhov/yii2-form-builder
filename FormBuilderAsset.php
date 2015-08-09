<?php
/**
 * @author Anton Tuyakhov <atuyakhov@gmail.com>
 */

namespace tuyakhov\formbuilder;


use yii\web\AssetBundle;

class FormBuilderAsset extends AssetBundle
{
    public $sourcePath = '@bower/jquery.formbuilder/dist';

    public $js = [
        'js/formbuilder.min.js'
    ];

    public $css = [
        'css/formbuilder.css',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
        'tuyakhov\formbuilder\DustAsset',
        'tuyakhov\formbuilder\Html5SortableAsset'
    ];
}