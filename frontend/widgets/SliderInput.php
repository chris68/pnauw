<?php
/**
 * @license http://www.yiiframework.com/license/
 */

namespace frontend\widgets;

use yii\helpers\Html;
use yii\jui\InputWidget;

/*
 * This is a rewrite of the SliderInput from the Yii Framework
 * It uses disabled standard input fields instead of hidden field
 * The reason is that hidden input field are not reset upon a form reset
 * See: http://stackoverflow.com/questions/6367793/why-does-the-reset-button-on-html-forms-not-reset-hidden-fields
 */
class SliderInput extends InputWidget
{
	protected $clientEventsMap = [
		'change' => 'slidechange',
		'create' => 'slidecreate',
		'slide' => 'slide',
		'start' => 'slidestart',
		'stop' => 'slidestop',
	];

	/**
	 * Executes the widget.
	 */
	public function run()
	{
		echo Html::tag('div', '', $this->options);

		$inputId = $this->id.'-input';
		$inputOptions = $this->options;
		$inputOptions['id'] = $inputId;
		$inputOptions['style'] = 'display:none;'.((isset($inputOptions['style']))?$inputOptions['style']:'');
		
		if ($this->hasModel()) {
			echo Html::activeInput('text', $this->model, $this->attribute, $inputOptions);
		} else {
			echo Html::input('text', $this->name, $this->value, $inputOptions);
		}

		if (!isset($this->clientEvents['slide'])) {
			$this->clientEvents['slide'] = 'function(event, ui) {
				$("#'.$inputId.'").val(ui.value);
			}';
		}

		$this->registerWidget('slider', \yii\jui\SliderAsset::className());
		$this->getView()->registerJs('$("#'.$inputId.'").val($("#'.$this->id.'").slider("value"));');
	}
}