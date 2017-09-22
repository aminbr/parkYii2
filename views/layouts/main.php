<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use yii\web\JqueryAsset;
AppAsset::register($this);
JqueryAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link type="icon" rel="icon" href="img/logo-main.png" />
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<style>
    @import url(fonts/yekan.css);
    body{
        background-color: #eeeeee;
        font-family: 'yekan';
        /*direction: rtl;*/
    }
    ul li{
        text-align: right;
    }
</style>
<body>
<?php $this->beginBody() ?>
    <div class="background-img"></div>
<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => 'پارکینگ',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            (isset(Yii::$app->user->identity->level) and Yii::$app->user->identity->level == 1 || Yii::$app->user->identity->level == 3) ? 
                ['label' => 'کنسول', 'url' => ['/parking/consol']] : "",
            
            (isset(Yii::$app->user->identity->level) and (Yii::$app->user->identity->level == 3 || Yii::$app->user->identity->level == 8 || Yii::$app->user->identity->level == 6)) ?
            ['label' => 'تنظیمات',
                'items' => [
                    (isset(Yii::$app->user->identity->level) and Yii::$app->user->identity->level == 3) ? 
                        ['label' => 'ساخت کاربر', 'url' => ['/user/createuser']]:'',
                    (isset(Yii::$app->user->identity->level) and Yii::$app->user->identity->level == 8) ? 
                        ['label' => 'ایجاد کارت', 'url' => ['/card/createcard']]:'',
                    (isset(Yii::$app->user->identity->level) and Yii::$app->user->identity->level == 8) ? 
                        ['label' => 'تنظیم مجدد کارت', 'url' => ['/card/resetcard']]:'',
                    (isset(Yii::$app->user->identity->level) and Yii::$app->user->identity->level == 3) ? 
                        ['label' => 'برداشت از صندوق', 'url' => ['/setting/cashremoval']]:'',
                    (isset(Yii::$app->user->identity->level) and Yii::$app->user->identity->level == 3) ? 
                        ['label' => 'تنظیمات اولیه', 'url' => ['/setting/basicsetting']]:'',
                    (isset(Yii::$app->user->identity->level) and Yii::$app->user->identity->level == 3) ? 
                        ['label' => 'تشخیص نوع کارت', 'url' => ['/setting/findcard']]:'',
                    (isset(Yii::$app->user->identity->level) and Yii::$app->user->identity->level == 6) ? 
                        ['label' => 'تنظیمات آی پی', 'url' => ['/setting/ipsetting']]:'',
                    (isset(Yii::$app->user->identity->level) and Yii::$app->user->identity->level == 6) ? 
                        ['label' => 'تنظیمات دوربین', 'url' => ['/setting/camerasetting']]:'',
                ],
            ] :"",
            
            (isset(Yii::$app->user->identity->level) and (Yii::$app->user->identity->level == 3 )) ?
            ['label' => 'صدور کارت',
                'items' => [
                    (isset(Yii::$app->user->identity->level) and Yii::$app->user->identity->level == 3) ? 
                        ['label' => 'صدور کارت تخفیف دار', 'url' => ['/card/setpercent']]:'',
                    (isset(Yii::$app->user->identity->level) and Yii::$app->user->identity->level == 3) ? 
                        ['label' => 'صدور کارت ویژه', 'url' => ['/card/setvip']]:'',
                    (isset(Yii::$app->user->identity->level) and Yii::$app->user->identity->level == 3) ? 
                        ['label' => 'صدور کارت پرسنلی', 'url' => ['/card/setpersonnel']]:'',
                    ],
            ] :"",
            
            (isset(Yii::$app->user->identity->level) and (Yii::$app->user->identity->level == 3 || Yii::$app->user->identity->level == 2)) ?
                ['label' => 'گزارشات',
                    'items' => [
                        (isset(Yii::$app->user->identity->level) and Yii::$app->user->identity->level == 3 || Yii::$app->user->identity->level == 2) ? 
                            ['label' => 'گزارش پارکینگ', 'url' => ['/report/parking']]:'',
                        (isset(Yii::$app->user->identity->level) and Yii::$app->user->identity->level == 3 || Yii::$app->user->identity->level == 2) ? 
                            ['label' => 'گزارش تفضیلی', 'url' => ['/report/detail']]:'',
                        (isset(Yii::$app->user->identity->level) and Yii::$app->user->identity->level == 3 || Yii::$app->user->identity->level == 2) ? 
                            ['label' => 'گزارش صندوق', 'url' => ['/report/fund']]:'',
                        (isset(Yii::$app->user->identity->level) and Yii::$app->user->identity->level == 3 || Yii::$app->user->identity->level == 2) ? 
                            ['label' => 'گزارش مالی', 'url' => ['/report/fundparking']]:'',
                        (isset(Yii::$app->user->identity->level) and Yii::$app->user->identity->level == 3 || Yii::$app->user->identity->level == 2) ? 
                            ['label' => 'گزارش کاربران', 'url' => ['/report/listuser']]:'',
                        (isset(Yii::$app->user->identity->level) and Yii::$app->user->identity->level == 3 ) ? 
                            ['label' => 'گزارش کارت های ویژه', 'url' => ['/report/listvip']]:'',
                        (isset(Yii::$app->user->identity->level) and Yii::$app->user->identity->level == 3 ) ? 
                            ['label' => 'گزارش کارت های پرسنلی', 'url' => ['/report/listpersonnel']]:'',
                    ],
                ] :"",
            
            (isset(Yii::$app->user->identity->level) and Yii::$app->user->identity->level == 2 || Yii::$app->user->identity->level == 3) ? 
                ['label' => 'درباره ما', 'url' => ['/parking/about']] : "",
            
            Yii::$app->user->isGuest ? (
                ['label' => 'ورود اعضا', 'url' => ['/parking/login']]
            ) : ['label' => 'خروج', 'url' => ['/parking/logout']],
//            ) : ['label' => '(خروج (' .Yii::$app->user->identity->nickname.'', 'url' => ['/parking/logout']],

        ],
    ]);
    NavBar::end();
    ?>

    <div class="container-fluid">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <div class="">
            <?= $content ?>
        </div>
    </div>
</div>

<!--<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?php // date('Y') ?></p>

        <p class="pull-right"><?php // Yii::powered() ?></p>
    </div>
</footer>-->

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
