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
        'vendor/fontawesome-free/css/all.css',
        'css/sb-admin-2.css',
    ];
    public $js = [
        /* Bootstrap core JavaScript */
        //'vendor/jquery/jquery.min.js',
        'vendor/bootstrap/js/bootstrap.bundle.min.js',
        /* Core plugin JavaScript */
        'vendor/jquery-easing/jquery.easing.min.js',
        /* Custom scripts for all pages */
        'js/sb-admin-2.min.js',
        /* Page level plugins */
        'vendor/chart.js/Chart.min.js',
        /* Page level custom scripts */
        'js/demo/chart-area-demo.js',
        'js/demo/chart-pie-demo.js',
        /*  Page level plugins */
        "vendor/datatables/jquery.dataTables.min.js",
        "vendor/datatables/dataTables.bootstrap4.min.js",
        /*  Page level custom scripts */
        "js/demo/datatables-demo.js",
        /* sweetalert2 */
        "vendor/sweetalert2/sweetalert2.all.min.js",
        /* validacion */
        "js/validacion.js",
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap4\BootstrapAsset',
    ];
}
