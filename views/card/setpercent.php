<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\widgets\Pjax;
use yii\widgets\ActiveForm;

$this->title = 'صدور کارت تخفیف دار';
?>

<div class="body-content text-right">
    <div class="col-xs-12 col-sm-6 col-md-6 col-md-offset-3">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="col-xs-12 col-sm-12 col-md-12 ">
                    <h2> صدور کارت تخفیف دار<small>لطفا فیلدها را با دقت پر کنید</small></h2>
                    <hr class="colorgraph">
                    
                        
                    <?php
//                        Pjax::begin(['id' => 'form-pjax-percent',
//                            'enablePushState' => false,
//                            'timeout' => false
//                        ]); 
                    ?>
                    <?php
                    $form = ActiveForm::begin([
                                'id' => 'form-percent',
                                'options' => [
                                    'data-pjax' => 1
                                ]
                            ]);
                    ?>
                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                    <?= $form->field($setCard, "percent")->textInput([
                        'class' => 'form-control input-lg',
                        'dir' => 'rtl',
                        'placeholder' => 'درصد را وارد کنید',
                        'tabindex' => '2',
                        'maxlength' => '2',
                    ]);
                    ?>
                        </div>
                        <div class="col-lg-6 col-md-6">
                    <?= $form->field($setCard, "tagInput")->textInput([
                        'class' => 'form-control input-lg',
                        'dir' => 'rtl',
                        'placeholder' => 'تگ ورود را وارد کنید',
                        'tabindex' => '1',
                        'maxlength' => '16',
                    ]);
                    ?>
                        </div>
                    <?= $form->field($setCard, 'typeInput')->hiddenInput([
                        'value' => 'percent',
                    ])->label('');
                    ?>

                    <?= \yii\helpers\Html::submitInput('ثبت کارت', [
                        'class' => 'btn btn-success btn-block btn-lg',
                        'tabindex' => '3',
                    ]);
                    ?>
                    </div>
                    <?php ActiveForm::end() ?>
                    <?php // Pjax::end() ?>
                </div>
            </div>
        </div>
    </div>
</div>