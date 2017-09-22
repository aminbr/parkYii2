<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = 'تنظیمات دوربین';

$form = ActiveForm::begin();
?>

<div class="text-right">
    <div class="body-content">
        <div class="">
            <div class="col-xs-12 col-sm-6 col-md-6 col-md-offset-3">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="col-xs-12 col-sm-8 col-md-12 ">
                            <h2>تنظیمات دوربین <small>لطفا فیلدها را با دقت پر کنید</small></h2>
                            <hr class="colorgraph">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <?=
                                            $form->field($cameraModel, 'url_enter')->textInput([
                                                'class' => 'form-control input-lg',
                                                'dir' => 'rtl',
                                                'placeholder' => 'آدرس دوربین ورود را وارد کنید',
                                                'tabindex' => '1',
                                            ]);        
                                        ?>

                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <?=
                                            $form->field($cameraModel, 'url_exit')->textInput([
                                                'class' => 'form-control input-lg',
                                                'dir' => 'rtl',
                                                'placeholder' => 'آدرس دوربین خروج را وارد کنید',
                                                'tabindex' => '2',
                                            ]);        
                                        ?>

                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <?=
                                            $form->field($cameraModel, 'url_capture')->textInput([
                                                'class' => 'form-control input-lg',
                                                'dir' => 'rtl',
                                                'placeholder' => 'آدرس عکس دوربین ورود را وارد کنید',
                                                'tabindex' => '3',
                                            ]);        
                                        ?>

                                    </div>
                                </div>
                            </div>


                            <!--<hr class="colorgraph">-->
                            <div class="row">
                                <div class="col-xs-12 col-md-12">
                                    <?=
                                        Html::submitInput('ثبت', [
                                            'class' => 'btn btn-success btn-block btn-lg',
                                            'tabindex' => '4',
                                        ]);
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    <?php 
        ActiveForm::end(); 
    ?>
