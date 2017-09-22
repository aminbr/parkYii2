<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
$form = ActiveForm::begin();
$this->title = $title;
?>

<div class="body-content text-right">
    <div class="col-xs-12 col-sm-6 col-md-6 col-md-offset-3">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="col-xs-12 col-sm-12 col-md-12 ">
                    <h2> <?= $title ?><small>لطفا فیلدها را با دقت پر کنید</small></h2>
                    <hr class="colorgraph">
                    <div class="row">
                        <?php 
                            if($type == 'edit' || $type == 'register'){
                        ?>
                        <div class="col-md-6">
                            <?= $form->field($cardPersonnelModel, 'nt_code')->textInput([
                                'class' => 'form-control input-lg',
                                'dir' => 'rtl',
                                'placeholder' => 'کدملی را وارد کنید',
                                'tabindex' => '2',
                                'maxlength' => '10',
                            ]); ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($cardPersonnelModel, 'name')->textInput([
                                'class' => 'form-control input-lg',
                                'dir' => 'rtl',
                                'placeholder' => 'نام را وارد کنید',
                                'tabindex' => '1',
                                'maxlength' => '30',
                            ]); ?>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="<?php if($type == 'edit'){echo 'col-md-12';}else{echo 'col-md-6';} ?>">
                            <?= $form->field($cardPersonnelModel, 'plate_car')->textInput([
                                'class' => 'form-control input-lg',
                                'dir' => 'rtl',
                                'placeholder' => 'شماره پلاک را وارد کنید',
                                'tabindex' => '3',
                                'maxlength' => '16',    
                            ]); ?>
                        </div>
                        <?php 
                            }
                        ?>
                        <?php 
                            if($type == 'update' || $type == 'register'){
                        ?>
                        <div class="col-md-6"></div>
                        <div class="col-md-6">
                            <?= $form->field($cardPersonnelModel, 'days')->textInput([
                                'class' => 'form-control input-lg',
                                'dir' => 'rtl',
                                'placeholder' => 'روزهای اعتبار را وارد کنید',
                                'tabindex' => '4',
                                'maxlength' => '4',
                            ]); ?>
                        </div>
                        <?php } ?>
                    </div>
                    <?php 
                        if($type == 'edit' || $type == 'register'){
                    ?>
                    <div class="row">
                        <div class="col-md-6 col-md-offset-6">
                            <?= $form->field($cardPersonnelModel, 'card_number')->textInput([
                                'class' => 'form-control input-lg',
                                'dir' => 'rtl',
                                'placeholder' => 'شماره کارت را وارد کنید',
                                'tabindex' => '5',
                                'maxlength' => '16',
                            ]); ?>
                        </div>
                    </div>
                    <?php } ?>
                    <?= Html::submitInput('ثبت کارت', [
                        'class' => ($data == 'edit') ? 'btn btn-info pull-right btn-block btn-lg':'btn btn-success pull-right btn-block btn-lg',
                        'tabindex' => '6',
                    ]); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>
