<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use yii\widgets\MaskedInput;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = 'تنظیمات آی پی';

$form = ActiveForm::begin();
?>

<div class="text-right">
    <div class="body-content">
        <div class="">
            <div class="col-xs-12 col-sm-6 col-md-6 col-md-offset-3">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="col-xs-12 col-sm-8 col-md-12 ">
                            <h2>تنظیمات آی پی <small>لطفا فیلدها را با دقت پر کنید</small></h2>
                            <hr class="colorgraph">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <?=
                                            $form->field($settingSysModel, 'ip')->textInput([
                                                'class' => 'form-control input-lg',
                                                'dir' => 'rtl',
                                                'placeholder' => 'آی پی سیستم را وارد کنید',
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
                                            $form->field($settingSysModel, 'ip2')->textInput([
                                                'class' => 'form-control input-lg',
                                                'dir' => 'rtl',
                                                'placeholder' => 'آی پی سیستم را وارد کنید',
                                                'tabindex' => '1',
                                            ]);        
                                        ?>

                                    </div>
                                </div>
                            </div>


                            <!--<hr class="colorgraph">-->
                            <div class="row">
                                <div class="col-xs-12 col-md-12">
                                    <?=
                                        Html::submitInput('ثبت آی پی', [
                                            'class' => 'btn btn-success btn-block btn-lg',
                                            'tabindex' => '2',
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
