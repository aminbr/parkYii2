<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'تنظیمات اولیه';

$form = ActiveForm::begin();
?>

<div class="text-right">
    <div class="body-content">
        <div class="">
            <div class="col-xs-12 col-sm-6 col-md-6 col-md-offset-3">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="col-xs-12 col-sm-8 col-md-12 ">
                            <h2>تنظیمات اولیه <small>لطفا فیلدها را با دقت پر کنید</small></h2>
                            <hr class="colorgraph">
                            <div class="row">
                                <div class="col-xs-12 col-sm-6 col-md-6">
                                    <div class="form-group">
                                        <?=
                                        $form->field($settingModel, 'input_hour')->textInput([
                                            'class' => 'form-control input-lg',
                                            'dir' => 'rtl',
                                            'placeholder' => '0000',
                                            'tabindex' => '2',
                                            'maxlength' => '4',
                                            'type' => 'number',
                                        ]);
                                        ?>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-6">
                                    <div class="form-group">
                                        <?=
                                        $form->field($settingModel, 'input_price')->textInput([
                                            'class' => 'form-control input-lg',
                                            'dir' => 'rtl',
                                            'placeholder' => '0000',
                                            'tabindex' => '1',
                                            'maxlength' => '4',
                                            'type' => 'number',
                                        ]);
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-6 col-md-6">
                                    <div class="form-group">
                                        <?=
                                        $form->field($settingModel, 'rounding_price')->textInput([
                                            'class' => 'form-control input-lg',
                                            'dir' => 'rtl',
                                            'placeholder' => '0000',
                                            'tabindex' => '4',
                                            'maxlength' => '4',
                                            'type' => 'number',
                                        ]);
                                        ?>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-6">
                                    <div class="form-group">
                                        <?=
                                        $form->field($settingModel, 'capacity')->textInput([
                                            'class' => 'form-control input-lg',
                                            'dir' => 'rtl',
                                            'placeholder' => '0000',
                                            'tabindex' => '3',
                                            'maxlength' => '4',
                                            'type' => 'number',
                                        ]);
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <!--<hr class="colorgraph">-->
                            <div class="row">
                                <div class="col-xs-12 col-md-12">
                                    <?=
                                    Html::submitInput('ثبت تنظیمات', [
                                        'class' => 'btn btn-success btn-block btn-lg',
                                        'tabindex' => '5',
                                    ])
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
<?php ActiveForm::end(); ?>

