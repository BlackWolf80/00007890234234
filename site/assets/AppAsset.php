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
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [

        'assets/bootstrap/css/bootstrap.min.css',
        'https://fonts.googleapis.com/css?family=Montserrat:400,400i,700,700i,600,600i',
        'assets/fonts/simple-line-icons.min.css',
        'https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.10.0/baguetteBox.min.css',
        'assets/css/styles.min.css',
        '/css/st123.css',

        'assets/fonts/fontawesome-all.min.css',
    ];
    public $js = [
        'assets/js/jquery.min.js',
        'assets/bootstrap/js/bootstrap.min.js',
//        'https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.10.0/baguetteBox.min.js',
//        'assets/js/script.min.js',
//        'https://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js',
        'js/script.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
//        'yii\bootstrap\BootstrapAsset',
    ];
}
