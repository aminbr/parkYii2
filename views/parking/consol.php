<?php
use yii\widgets\ActiveForm;
use kartik\widgets\Growl;
use yii\helpers\Html;
$config = Yii::$app->utility->getSetting();
$urlCamera = Yii::$app->utility->getUrl();
/* @var $this yii\web\View */
$this->title = 'کنسول';
//die(var_dump($urlCamera->url_enter));
//die(var_dump($_SERVER['SERVER_PORT']));
?>
<style>
    .box-status{
        font-size: 22px;
    }
    h4{
        font-size: 22px;
    }
    .form-group{
        margin: 0px;
    }
</style>
<div class="text-right">
    <div class="body-content">
        <div class="col-xs-12 col-sm-12 col-md-12" style="opacity: 0.95;">
                <div class="panel">
                    <div class="panel-body">
                        <div class="col-xs-12 col-sm-12 col-md-12 ">
                            <div class="row">
                                <div class="col-md-12">
                                    <h3>کنسول</h3>
                                </div>
                            </div>
                                <hr class="colorgraph">
                                <div class="row col-md-12">
                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                        <div class="col-md-6 col-sm-6 col-xs-6" style="position: relative;">
                                            دوربین خروج<br /><br />
                                            <img src="<?= $urlCamera->url_exit ?>" id="box-video-enter" style="position: absolute; left: 0; z-index: 1; height: 320px;width: 95%;border: 1px solid #eee;border-radius: 10px; box-shadow: 3px 3px 15px rgba(51, 51, 51, 0.2);">
                                            <img src="" id="box-video-enter-front" style="position: absolute; left: 0; z-index: 0; height: 320px;width: 95%;border: 1px solid #eee;border-radius: 10px;">
                                            <!--<img src="http://root:h3am1767@192.168.1.11/cgi-bin/viewer/video.jpg?resolution=640x480" id="box-video-enter-front" style="position: absolute; left: 0; z-index: 0; height: 320px;width: 95%;border: 1px solid #cccccc;border-radius: 5px;">-->
                                                
                                            
                                        </div>
                                        <div class="col-md-6  col-sm-6 col-xs-6">
                                            دوربین ورود<br /><br />
                                            <img src="<?= $urlCamera->url_enter ?>" id="box-video-exit" style="height: 320px;width: 95%;border: 1px solid #eee;border-radius: 10px; box-shadow: 3px 3px 15px rgba(51, 51, 51, 0.2);">
                                            
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                        <div class="row">
                                            <div class="">
                                                <p>
                                                    <?php
                                                    if( Yii::$app->user->identity->level == 1) {
                                                    ?>
                                                    <?php \yii\widgets\Pjax::begin(['id' => 'form-pjax-enter',
                                                        'enablePushState' => false,
                                                        'timeout' => false]); 
                                                    ?>
                                                    <?php $form = ActiveForm::begin([
                                                        'id' => 'form-enter',
                                                        'options' => [
                                                            'data-pjax' => 1
                                                        ]
                                                    ]); ?>
                                                        <?= $form->field($cardReaderModel, "tagInput")->passwordInput([
                                                            'class' => 'form-control input-lg',
                                                            'dir' => 'rtl',
                                                            'placeholder' => 'تگ ورود را وارد کنید',
                                                            'tabindex' => '1',
                                                            'maxlength' => '16',
//                                                            'type' => 'number',
                                                        ]); ?>
                                                        <?= $form->field($cardReaderModel, 'typeInput')->hiddenInput([
                                                            'value' => 'enter'
                                                        ])->label(''); ?>
                                                    <?php ActiveForm::end() ?>
                                                    <?php 
                                                        foreach (Yii::$app->session->getAllFlashes() as $flash) {
                                                            echo Growl::widget([
                                                              'type' => Growl::TYPE_SUCCESS,
    //                                                            'title' => 'خروج خودرو',
    //                                                            'icon' => 'glyphicon glyphicon-remove-sign',
                                                                'body' => 'ورود با موفقیت انجام شد',
                                                                'pluginOptions' => [
                                                                    'placement' => [
                                                                        'from' => 'top',
                                                                        'align' => 'right',
                                                                    ]
                                                                ]
                                                            ]);
                                                        }
                                                    ?>
                                                    <?php \yii\widgets\Pjax::end() ?>
                                                </p>
                                                
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="">
                                                <p>
                                                <?php \yii\widgets\Pjax::begin(['id' => 'form-pjax-exit',
                                                    'enablePushState' => false,
                                                    'timeout' => false]);
                                                ?>
                                                <?php $form = ActiveForm::begin([
                                                    'id' => 'form-exit',
                                                    'options' => [
                                                        'data-pjax' => 1
                                                    ]
                                                ]); ?>
                                                <?php

                                                echo $form->field($cardReaderModel, "tagInput")->passwordInput([
                                                        'class' => 'form-control input-lg',
                                                        'dir' => 'rtl',
                                                        'placeholder' => 'تگ خروج را وارد کنید',
                                                        'tabindex' => '1',
                                                        'maxlength' => '16',
                                                        'onkeydown' => 'keyDown(this)',
                                                        'id' => 'tagExit',
//                                                            'type' => 'number',
                                                    ]);

                                                ?>

                                                    <?= $form->field($cardReaderModel, 'typeInput')->hiddenInput([
                                                        'value' => 'exit'
                                                    ])->label(''); ?>
                                                <?php ActiveForm::end() ?>
                                                <?php
                                                if($typeCard == 1 || $typeCard == 2){
                                                    if($price != NULL || $price == "0"){
                                                    ?>
                                                    <script>
                                                        $("#lblViewPrice").text("مبلغ"+<?= $price ?>+"تومان");
                                                        $("#lblViewParkTime").text("زمان پارک"+'<?= $data = Yii::$app->utility->getTimeSpanFromSeconds($parkTime); ?>'+"می باشد");
                                                        $("#lblViewPrice, #lblViewParkTime, #lblPlateCar").click(function (){
                                                            $("#lblViewPrice").text("");
                                                            $("#lblViewParkTime").text("");
                                                        });
                                                        $("#tagExit").attr("disabled", true);
                                                        setTimeout(function (){
                                                            $("#tagExit").attr("disabled", false);
                                                        },5000);
                                                        $("#btnOpenGate").css("display", "block");
                                                    </script>
                                                <?php
                                                    }
                                                }else if($typeCard == 3){
                                                    ?>
                                                    <script>
                                                        $("#lblViewPrice").text("خودرو ویژه تعداد روزهای اعتبار:<?= $validateDay ?>");
                                                        $("#lblViewParkTime").text("زمان پارک"+'<?= $data = Yii::$app->utility->getTimeSpanFromSeconds($parkTime); ?>'+"می باشد");
                                                        $("#lblPlateCar").text("شماره پلاک:<?= $plateVip ?>");
                                                        $("#lblValidDay").text("تعداد روزهای اعتبار :<?= $validateDay ?>");
                                                        $("#lblViewPrice, #lblViewParkTime, #lblPlateCar").click(function (){
                                                            $("#lblViewPrice").text("");
                                                            $("#lblViewParkTime").text("");
                                                            $("#lblPlateCar").text("");
                                                            $("#lblValidDay").text("");
                                                        });
                                                        $("#tagExit").attr("disabled", true);
                                                        setTimeout(function (){
                                                            $("#tagExit").attr("disabled", false);
                                                        },5000);
                                                        $("#btnOpenGate").css("display", "block");
                                                    </script>
                                                    <?php
                                                }else if($typeCard == 4){
                                                    ?>
                                                    <script>
                                                        $("#lblViewPrice").text("خودرو پرسنل تعداد روزهای اعتبار:<?= $validateDay ?>");
                                                        $("#lblViewParkTime").text("زمان پارک"+'<?= $data = Yii::$app->utility->getTimeSpanFromSeconds($parkTime); ?>'+"می باشد");
                                                        $("#lblPlateCar").text("شماره پلاک:<?= $plateVip ?>");
                                                        $("#lblValidDay").text("تعداد روزهای اعتبار :<?= $validateDay ?>");
                                                        $("#lblViewPrice, #lblViewParkTime, #lblPlateCar").click(function (){
                                                            $("#lblViewPrice").text("");
                                                            $("#lblViewParkTime").text("");
                                                            $("#lblPlateCar").text("");
                                                            $("#lblValidDay").text("");
                                                        });
                                                        $("#tagExit").attr("disabled", true);
                                                        setTimeout(function (){
                                                            $("#tagExit").attr("disabled", false);
                                                        },5000);
                                                        $("#btnOpenGate").css("display", "block");
                                                    </script>
                                                    <?php
                                                }
                                                ?>
                                                <?php 
                                                foreach (Yii::$app->session->getAllFlashes() as $flash) {
                                                    echo Growl::widget([
                                                      'type' => Growl::TYPE_SUCCESS,
//                                                            'title' => 'خروج خودرو',
//                                                            'icon' => 'glyphicon glyphicon-remove-sign',
                                                        'body' => 'مبلغ'.$price.' تومان',
                                                        'pluginOptions' => [
                                                            'placement' => [
                                                                'from' => 'top',
                                                                'align' => 'right',
                                                            ]
                                                        ]
                                                    ]);
                                                }
                                                
                                                ?>
                                                <?php \yii\widgets\Pjax::end() ?>
                                                </p>
                                                
                                                <h4 id="lblViewPrice" class="text-success"></h4>
                                                <h4 id="lblViewParkTime" class="text-primary"></h4>
                                                <h4 id="lblPlateCar" class="text-primary"></h4>
                                                <h4 id="lblvalidDay" class="text-primary"></h4>
                                                <button style="display: none;" class="btn btn-success btn-block" id="btnOpenGate">
                                                    باز کردن گیت خروج
                                                </button>
                                                <?php
                                                }else
                                                {
                                                    echo '';
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="box-status">
                                    <h3>وضعیت پارکینگ</h3>
                                    <hr class="colorgraph">
                                    <div class="col-md-3 col-md-offset-3">
                                        ظرفیت:<span id="capacityParking"></span>
                                    </div>
                                    <div class="col-md-3">
                                       <span id="capacityParking"><?= Yii::$app->user->identity->nickname; ?> </span>: کاربر وارد شده
                                    </div>
                                    <div class="col-md-3">
                                        صندوق: <span id="fundParking"></span>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
<!--            <div class="col-xs-12 col-sm-12 col-md-12" style="opacity: 0.9;">
                    <div class="panel">
                        <div class="panel-body">
                            <div class="col-xs-12 col-sm-12 col-md-12 ">

                                    <h3>وضعیت پارکینگ</h3>
                                    <hr class="colorgraph">
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6">
                                            <h4><span ></span>: ظرفیت پارکینگ</h4>
                                        </div>
                                        <div class="col-md-6 col-sm-6">
                                            <h4> </h4>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6">
                                            
                                        </div>
                                        <div class="col-md-6 col-sm-6">
                                            <h4>  :کاربر وارد شده  </h4>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>
            </div>-->
    </div>
</div>

<?php

$this->registerJs(
    "$('#btnOpenGate').click(function(){
        $.ajax({
            url: '".Yii::$app->urlManager->CreateAbsoluteUrl(['parking/opengateenter'])."',
            success: function (returnData) {
                if(returnData)
                {
                    $('#btnOpenGate').css('display', 'none');
                }
            }
        })
    });
        
    loadParking();
    function loadParking(){
        $.ajax({
            url: '".Yii::$app->urlManager->CreateAbsoluteUrl(['parking/parkingcapacity'])."',
            method: 'GET',
            dataType: 'JSON',
            success: function (returnData) {
//                console.log(returnData);
                if(returnData.level == 3){
                    $('#capacityParking').text(returnData.capacity);
                    var num = returnData.totalAmount;
                    $('#fundParking').text(num.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, '$1,'));
                }else{
                    $('#capacityParking').text(returnData.capacity);
                    var num = returnData.fund;
                    $('#fundParking').text(num.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, '$1,'));
                }
            }
        })
        setTimeout(loadParking,1800); 
    }
    

    var tagnum;
    function keyDown(obj){
        tagnum = $(obj).val();
    }
    loadImg();
    function loadImg(){
        var d = new Date();
        var n = d.getTime();
        $('#box-video-enter').attr('src' , '".$urlCamera->url_enter."'+'?1&n='+n);
        $('#box-video-exit').attr('src' , '".$urlCamera->url_exit."'+'?1&n='+n);
        setTimeout(loadImg,1500); 
    }
        $('#form-pjax-exit').on('pjax:success', function(){
            $('#box-video-enter-front').attr('src', '".Yii::$app->urlManager->createAbsoluteUrl('parking/image-url')."&tagnum='+tagnum+'&v=".uniqid()."');
                $('#box-video-enter-front').css('z-index', '1'); 
                $('#box-video-enter-front').css('display', 'block'); 
                $('#box-video-enter').css('z-index', '0'); 
            setTimeout(function(){
                $('#box-video-enter').css('z-index', '1'); 
                $('#box-video-enter-front').css('z-index', '0'); 
                $('#box-video-enter-front').css('display', 'none'); 
//                $('#box-video-enter-front').attr('src', '');
            }, ".$config['parking']['freeze_time'].");
        });
", yii\web\View::POS_END);