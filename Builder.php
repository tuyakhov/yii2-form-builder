<?php
/**
 * @author Anton Tuyakhov <atuyakhov@gmail.com>
 */

namespace tuyakhov\formbuilder;


use yii\base\Model;
use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;

class Builder extends  Widget
{

    public $containerSelector;

    public $startingModel;

    public $saveCallback;

    public $templateBasePath;

    public function run()
    {
        $jsonModel = Json::encode(empty($this->startingModel) ? '{}' : $this->startingModel);
        if ($this->templateBasePath === null) {
            $this->templateBasePath = \Yii::$app->assetManager->getPublishedUrl('@bower/jquery.formbuilder/dist') . '/templates/builder';
        }
        $view = $this->getView();
        FormBuilderAsset::register($view);
        $view->registerJs("var myForm = new formbuilder({
            templateBasePath: '{$this->templateBasePath}',
            targets: $('{$this->containerSelector}'),
            save: " . new JsExpression($this->saveCallback) . ",
            startingModel: {$jsonModel}
        });");
    }
}