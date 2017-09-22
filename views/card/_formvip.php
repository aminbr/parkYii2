<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = $title;
?>

<div class="body-content text-right">
    <div class="col-xs-12 col-sm-6 col-md-6 col-md-offset-3">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="col-xs-12 col-sm-12 col-md-12 ">
                    <h2><?= $title ?><small>لطفا فیلدها را با دقت پر کنید</small></h2>
                    <hr class="colorgraph">
                    <?php
//                        Pjax::begin(['id' => 'form-pjax-vip',
//                            'enablePushState' => false,
//                            'timeout' => false
//                        ]);
                    ?>
                    <?php
                    $form = ActiveForm::begin([
                                'id' => 'form-vip',
                                'options' => [
                                    'data-pjax' => 1
                                ]
                            ]);
                    ?>
                    <?php 
                        if($type == 'edit' || $type == 'register'){
                    ?>
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-6">
                            <?=
                            $form->field($setVip, "nt_code")->textInput([
                                'class' => 'form-control input-lg',
                                'dir' => 'rtl',
                                'placeholder' => 'کد ملی را وارد کنید',
                                'tabindex' => '2',
                                'maxlength' => '10',
                            ]);
                            ?>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6">
                            <?=
                            $form->field($setVip, 'name')->textInput([
                                'class' => 'form-control input-lg',
                                'dir' => 'rtl',
                                'placeholder' => 'نام را وارد کنید',
                                'tabindex' => '1',
                            ]);
                            ?>
                        </div>
                    </div>
                    <?php 
                        }
                    ?>
                    <?php 
                        if($type == 'update' || $type == 'register'){
                    ?>
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-6">
                            <?php 
                                echo $form->field($setVip, "days")->textInput([
                                    'class' => 'form-control input-lg',
                                    'dir' => 'rtl',
                                    'placeholder' => 'روز را وارد کنید',
                                    'tabindex' => '4',
                                    'maxlength' => '4',
                                ]);
                            ?>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6">
                            <?=
                            $form->field($setVip, "price")->textInput([
                                'class' => 'form-control input-lg',
                                'dir' => 'rtl',
                                'placeholder' => 'قیمت را وارد کنید',
                                'tabindex' => '3',
                                'maxlength' => '7',
                            ]);
                            ?>
                        </div>
                    </div>
                    <?php
                        }
                    ?>
                    <?php 
                        if($type == 'edit' || $type == 'register'){
                    ?>
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-6">
                            <?=
                            $form->field($setVip, "model_car")->textInput([
                                'class' => 'form-control input-lg',
                                'dir' => 'rtl',
                                'placeholder' => 'مدل خودرو را وارد کنید',
                                'tabindex' => '6',
                                'maxlength' => '16',
                            ]);
                            ?>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6">
                            <?=
                            $form->field($setVip, "plate_car")->textInput([
                                'class' => 'form-control input-lg',
                                'dir' => 'rtl',
                                'placeholder' => 'پلاک را وارد کنید',
                                'tabindex' => '5',
                                'maxlength' => '16',
                            ]);
                            ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-6 col-md-offset-6">
                            <?=
                            $form->field($setVip, "card_number")->textInput([
                                'class' => 'form-control input-lg',
                                'dir' => 'rtl',
                                'placeholder' => 'تگ را وارد کنید',
                                'tabindex' => '7',
                                'maxlength' => '16',
                            ]);
                            ?>
                        </div>
                    </div>
                    <?php 
                        }
                    ?>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <?=
                            Html::submitInput($valueBtn, [
                                'class' => ($data == 'edit') ? 'btn btn-info pull-right btn-block btn-lg':'btn btn-success pull-right btn-block btn-lg',
                                'tabindex' => '8',
                                'id' => 'take'
                            ]);
                            ?>
                            <?php  ActiveForm::end() ?>
                            <?php // Pjax::end() ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>