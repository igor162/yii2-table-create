<?php

/**
 * Created by PhpStorm.
 * User: igor
 * Date: 20.12.17
 * Time: 15:48
 */

namespace igor162\tableCreate;

use Yii;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\base\InvalidConfigException;

/**
 * Class CreateTable
 * @package igor162\tableCreate.
 *
 * @property array $thead
 * @property array $tbody
 * @property boolean $encode
 * @property string $classTable
 *
 *
 *
 */
class CreateTable extends \yii\base\Widget
{
    public $thead = [];
    public $tbody = [];
    public $encode = true;
    public $classTable = 'table-price';

    public $footerRowOptions = [];

    public $tableTemplate = <<< HTML
    {thead}
    {tbody}
HTML;

    public function init()
    {
        $view = $this->getView();
        CreateTableAsset::register($view);

        echo Html::beginTag("table", ["class" => $this->classTable]);
        echo $this->renderTable();
    }

    protected function renderTable()
    {
        echo $this->renderTHead();

        echo $this->renderTBody();

    }

    protected function renderTHead()
    {

        $theadData = [];
        $theadCell = ArrayHelper::getValue($this->thead, 'items', []);

        if (empty($theadCell)) {
            throw new InvalidConfigException("The 'items' option is required.");
        }

        foreach ($theadCell as $n => $item) {
            if (!array_key_exists('label', $item)) {
                throw new InvalidConfigException("The 'label' option is required.");
            }

            $encode = isset($item['encode']) ? $item['encode'] : true;
            $label = $encode ? Html::encode($item['label']) : $item['label'];

            $theadData[] = Html::tag('th', $label, ArrayHelper::getValue($item, 'options', []));

        }

        $thead = Html::tag('tr', implode("\n", $theadData), ArrayHelper::getValue($this->thead, 'options', []));

        return Html::tag('thead', $thead);

    }

    protected function renderTBody()
    {

        $TBodyData = '';
        $TBodyCell = ArrayHelper::getValue($this->tbody, 'items', '');

        if (empty($TBodyCell)) {
            throw new InvalidConfigException("The 'items' option is required.");
        }

        foreach ($TBodyCell as $n => $item) {

            $tr = ArrayHelper::getValue($item, 'tr', []);
            if (empty($tr)) { $tr = $item; }

            $trData = [];

            foreach ($tr as $i => $td) {

                $tdData = '';
                $tdOptions = [];

                $label = ArrayHelper::getValue($td, 'label', []);
                if (empty($label)) {
                    throw new InvalidConfigException("The 'label' option is required.");
                }

                $encode = isset($item['encode']) ? $item['encode'] : true;
                $label = $encode ? Html::encode($label) : $label;
                $icon = ArrayHelper::getValue($td, 'icon', []);
                $small = ArrayHelper::getValue($td, 'small', []);
                $ul = ArrayHelper::getValue($td, 'ul', []);

                if (!empty($icon)) {
                    $tdData .= Html::tag('div', $icon, ['class' => 'icon']);
                }

                if (!empty($small)) {
                    Html::tag('div', Html::encode($small), ['class' => 'type']);
                }

                if (!empty($ul)) {

                    $data = '';
                    $data .= Html::tag('div', Html::encode($label), ['class' => 'name']);
                    $data .= Html::tag('div', Html::encode($small), ['class' => 'type']);
                    $data .= Html::tag('ul', $this->renderLi($ul));

                    $tdData .= Html::tag('div', $data, ['class' => 'desk']);
                } else {
                    $tdData .= $label;
                    $tdOptions = ['class' => 'pr1'];
                }

                $trData[] = Html::tag('td', $tdData, $tdOptions);
            }

            $TBodyData .= Html::tag('tr', implode("\n", $trData));
        }

        return Html::tag('tbody', $TBodyData);
    }

    protected function renderLi($items, &$encode = true)
    {
        $li = [];
        foreach ($items as $val) {
            $label = $encode ? Html::encode($val) : $val;
            $li[] = Html::tag('li', $label);
        }

        return implode("\n", $li);
    }

    public function run()
    {
        echo Html::endTag("table");
    }

}

