<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = 'ایجاد کارت';

$form = ActiveForm::begin();
?>

<div class="text-right">
    <div class="body-content">
        <div class="">
            <div class="col-xs-12 col-sm-6 col-md-6 col-md-offset-3">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="col-xs-12 col-sm-8 col-md-12 ">
                            <h2>ایجاد کارت <small>لطفا فیلدها را با دقت پر کنید</small></h2>
                            <hr class="colorgraph">
                            <div class="row">
                                
                                <div class="col-xs-12 col-sm-6 col-md-6">
                                    <div class="form-group">
                                        <?=
                                        $form->field($cardModel, 'card_tag')->textInput([
                                            'class' => 'form-control input-lg',
                                            'dir' => 'rtl',
                                            'placeholder' => 'تگ را وارد کنید',
                                            'tabindex' => '1',
                                            'maxlength' => '16',
                                        ]);
                                        ?>

                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-6">
                                    <div class="form-group">
                                        <?=
                                            $form->field($cardModel, 'card_type')->dropDownList($cardtypeArray, [
                                                'prompt' => 'انتخاب کنید',
                                                'class' => 'form-control input-lg',
                                                'dir' => 'rtl',
                                                'tabindex' => '2',
                                            ]);
                                        ?>
                                    </div>
                                </div>
                            </div>


                            <!--<hr class="colorgraph">-->
<!--                            <div class="row">
                                <div class="col-xs-12 col-md-12">
                                    <?php // echo
//                                    Html::submitInput('ثبت کارت', [
//                                        'class' => 'btn btn-success btn-block btn-lg',
//                                        'tabindex' => '3',
//                                    ]);
                                    ?>
                                </div>
                            </div>-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    <?php ActiveForm::end(); ?>
