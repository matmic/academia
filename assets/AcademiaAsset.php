<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AcademiaAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/style.css',
		'css/select2.min.css',
    ];
    public $js = [
		'js/jquery-3.4.1.min.js',
		'js/select2.min.js',
		//'js/vendor.js',
		//'js/bundle.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
	public $jsOptions = ['position' => \yii\web\View::POS_HEAD];
}
