<?php
/**
 * @author Anton Tuyakhov <atuyakhov@gmail.com>
 */

namespace tuyakhov\formbuilder;


use yii\web\AssetBundle;

class DustAsset extends AssetBundle
{
    public $sourcePath = '@bower/dustjs-linkedin/dist';

    public $js = [
        'dust-full.min.js'
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];
}