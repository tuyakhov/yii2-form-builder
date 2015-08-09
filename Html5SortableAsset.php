<?php
/**
 * @author Anton Tuyakhov <atuyakhov@gmail.com>
 */

namespace tuyakhov\formbuilder;


use yii\web\AssetBundle;

class Html5SortableAsset extends AssetBundle
{
    public $sourcePath = '@bower/html5sortable';

    public $js = [
        'jquery.sortable.min.js'
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];
}