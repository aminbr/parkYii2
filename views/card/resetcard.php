<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use kartik\widgets\Growl;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = 'تنظیم مجدد کارت';

$form = ActiveForm::begin();
?>

<div class="text-right">
    <div class="body-content">
        <div class="">
            <div class="col-xs-12 col-sm-6 col-md-6 col-md-offset-3">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="col-xs-12 col-sm-8 col-md-12 ">
                            <h2>تنظیم مجدد کارت <small>لطفا فیلدها را با دقت پر کنید</small></h2>
                            <hr class="colorgraph">
                            <div class="row">
                                
                                <div class="col-xs-12 col-sm-6 col-md-6 col-md-offset-6">
                                    <div class="form-group">
                                        <?=
                                        $form->field($cardModel, 'cardNumber')->passwordInput([
                                            'class' => 'form-control input-lg',
                                            'dir' => 'rtl',
                                            'placeholder' => 'تگ را وارد کنید',
                                            'maxlength' => '16',
                                        ]);
                                        ?>

                                    </div>
                                </div>
                            </div>
                            <?php 
                                foreach (Yii::$app->session->getAllFlashes() as $flash) {
                                    echo Growl::widget([
                                      'type' => Growl::TYPE_SUCCESS,
                                        'body' => 'عملیات تنظیم مجدد کارت موفق آمیز بود',
                                        'pluginOptions' => [
                                            'placement' => [
                                                'from' => 'top',
                                                'align' => 'right',
                                            ]
                                        ]
                                    ]);
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    <?php ActiveForm::end(); ?>
