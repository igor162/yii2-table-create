<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 20.12.17
 * Time: 15:48
 */

namespace igor162\tableCreate;

use Yii;
use yii\web\AssetBundle;

class CreateTableAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@igor162/tableCreate/css';

    /**
     * @inheritdoc
     */
    public $css = [
        'table-style.css',
    ];
}
