<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'جستجوی کارت';
$form = ActiveForm::begin();
?>
<style>
    #typeCard{
        cursor: pointer;
        padding-top: 10px;
    }
</style>
<div class="body-content text-right">
    <div class="col-xs-12 col-sm-6 col-md-6 col-md-offset-3 col-sm-offset-3">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="col-xs-12 col-sm-12 col-md-12 ">
                    <h2> جستجوی کارت<small>لطفا فیلدها را با دقت پر کنید</small></h2>
                    <hr class="colorgraph">
                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                            <h2 id="typeCard"><?= $cardType ?></h2>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <?= $form->field($cardModel, "cardNumber")->passwordInput([
                                'class' => 'form-control input-lg',
                                'dir' => 'rtl',
                                'placeholder' => 'شماره کارت را وارد کنید',
                            ]);
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>
<?php
$this->registerJs("
    
    $('#typeCard').click(function(){
        $('#typeCard').text('');
    });
",  \yii\web\View::POS_END);