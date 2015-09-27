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
        });
        myForm.setModelValue = function( id, type, val ){

          // Some paths are namespaced
          var path = false;
          if( type.indexOf('.') > -1 ){
            path = type.split('.');
            type = path[0];
          }

          if( this._model[id] === undefined ){
            throw new Error('Model has no entry for ' + id);
          }

          if( this._model[id].type === undefined ){
            throw new Error('Invalid schema field ' + type + ' for model ' + id);
          }

          var fieldType = this.getFieldTypeByName( this._model[id].type );

          // Special handling for choice
          if( type === 'choices' ){

            var index = parseInt(path[1],10);

            // verify field is in schema
            if( this._model[id][type][index][path[2]] === undefined  ){
              throw new Error('Invalid choice schema field ' + path[2] + ' for model ' + id);
            }

            // set value
            this._model[id][type][index][path[2]] = val;

            return;

          }

          this._model[id][type] = val;

        };
        myForm.appendFieldToFormElementEditor = function( frmb_group, field, parentModel, existingModel, index ){

          // load additional details template
          if( field.template !== undefined ){

            // choices
            if( parentModel.choices !== undefined ){

              // Create a new model
              if( typeof existingModel !== 'object' ){
                existingModel = $.extend(true,{},field.choiceSchema);
                parentModel.choices.push( existingModel);
              }

              var bodyObj = {
                fbid: parentModel.fbid,
                model: existingModel
              };

              // new index
              index = (typeof index === 'number') ? index : (parentModel.choices.length - 1);
              bodyObj.fbid += '_choices.'+index;

              dust.render(field.template, bodyObj, function(err, out){
                frmb_group.find('.frmb-choices').append( out );
              });
            }
          }
        };");
    }
}