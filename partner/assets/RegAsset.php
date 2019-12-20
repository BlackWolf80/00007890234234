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
class RegAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/materialize.min.css',
        'https://fonts.googleapis.com/icon?family=Material+Icons',
        'css/gallery.css',
        'css/app.css',
//        'ass/bootstrap/css/bootstrap.min.css',
//        'ass/fonts/font-awesome.min.css',
//        'https://fonts.googleapis.com/css?family=Yanone+Kaffeesatz:400,700&amp;subset=cyrillic',
//        'ass/css/Data-Table-1.css',
//        'ass/css/Data-Table.css',
//        'https://cdn.datatables.net/1.10.15/css/dataTables.bootstrap.min.css',
//        'ass/css/Navigation-Clean.css',
//        'ass/css/interphace.css',

    ];
    public $js = [

//        '/js/jquery.min.js',
        'js/script.js',
//        'js/reg.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
//        'yii\bootstrap\BootstrapAsset',
    ];
}
