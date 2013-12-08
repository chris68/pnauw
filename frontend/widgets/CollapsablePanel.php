<?php
/**
 * @link http://www.yiiframework.com/
 */

namespace frontend\widgets;

use yii\bootstrap\Widget;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/*
 * This is a rewrite of the Collapse from the Yii Framework
 * It uses the panel classes instead of the obsolete accordion classes
 */
class CollapsablePanel extends Widget
{
	/**
	 * @var array list of groups in the collapse widget. Each array element represents a single
	 * group with the following structure:
	 *
	 * ```php
	 * // item key is the actual group header
	 * 'Collapsible Group Item #1' => [
	 *     // required, the content (HTML) of the group
	 *     'content' => 'Anim pariatur cliche...',
	 *     // optional the HTML attributes of the content group
	 *     'contentOptions' => [],
	 *     // optional the HTML attributes of the group
	 *     'options' => [],
	 * ]
	 * ```
	 */
	public $items = [];


	/**
	 * Initializes the widget.
	 */
	public function init()
	{
		parent::init();
		Html::addCssClass($this->options, 'panel-group');
	}

	/**
	 * Renders the widget.
	 */
	public function run()
	{
		echo Html::beginTag('div', $this->options) . "\n";
		echo $this->renderItems() . "\n";
		echo Html::endTag('div') . "\n";
		$this->registerPlugin('collapse');
	}

	/**
	 * Renders collapsible items as specified on [[items]].
	 * @return string the rendering result
	 */
	public function renderItems()
	{
		$items = [];
		$index = 0;
		foreach ($this->items as $header => $item) {
			$options = ArrayHelper::getValue($item, 'options', []);
			Html::addCssClass($options, 'panel panel-default');
			$items[] = Html::tag('div', $this->renderItem($header, $item, ++$index), $options);
		}

		return implode("\n", $items);
	}

	/**
	 * Renders a single collapsible item group
	 * @param string $header a label of the item group [[items]]
	 * @param array $item a single item from [[items]]
	 * @param integer $index the item index as each item group content must have an id
	 * @return string the rendering result
	 * @throws InvalidConfigException
	 */
	public function renderItem($header, $item, $index)
	{
		if (isset($item['content'])) {
			$id = $this->options['id'] . '-collapse' . $index;
			$options = ArrayHelper::getValue($item, 'contentOptions', []);
			$options['id'] = $id;
			Html::addCssClass($options, 'panel-collapse collapse');

			$header = Html::a($header, '#' . $id, [
					'class' => 'panel-toggle',
					'data-toggle' => 'collapse',
					'data-parent' => '#' . $this->options['id']
				]) . "\n";

			$content = Html::tag('div', $item['content'], ['class' => 'panel-body']) . "\n";
		} else {
			throw new InvalidConfigException('The "content" option is required.');
		}
		$group = [];

		$group[] = Html::tag('div', Html::tag('h4', $header, ['class' => 'panel-title']), ['class' => 'panel-heading']);
		$group[] = Html::tag('div', $content, $options);

		return implode("\n", $group);
	}
}
