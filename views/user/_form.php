<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = $title;

$form = ActiveForm::begin();
?>
<div class="text-right">
    <div class="body-content">
        <div class="">
            <div class="col-xs-12 col-sm-6 col-md-6 col-md-offset-3">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="col-xs-12 col-sm-8 col-md-12 ">
                            <h2><?= $title ?><small>لطفا فیلدها را با دقت پر کنید</small></h2>
                            <hr class="colorgraph">
                            <div class="row">
                                <div class="col-xs-12 col-sm-6 col-md-6">
                                    <div class="form-group">
                                        <?=
                                        $form->field($userModel, 'username')->textInput([
                                            'class' => 'form-control input-lg',
                                            'dir' => 'rtl',
                                            'placeholder' => 'نام کاربری را وارد کنید',
                                            'tabindex' => '2',
                                            'maxlength' => '20',
                                        ]);
                                        ?>  
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-6">
                                    <div class="form-group">
                                        <?=
                                        $form->field($userModel, 'nickname')->textInput([
                                            'class' => 'form-control input-lg',
                                            'dir' => 'rtl',
                                            'placeholder' => 'نام کاربر را وارد کنید',
                                            'tabindex' => '1',
                                            'maxlength' => '20',
                                        ]);
                                        ?>   
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <?=
                                $form->field($userModel, 'email')->textInput([
                                    'class' => 'form-control input-lg',
                                    'dir' => 'rtl',
                                    'placeholder' => 'ایمیل را وارد کنید',
                                    'tabindex' => '3',
                                    'maxlength' => '40',
                                ]);
                                ?>  
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-6 col-md-6">
                                    <div class="form-group">
                                        <?=
                                        $form->field($userModel, 'level')->dropDownList($levelArray, [
                                            'prompt' => ' انتخاب کنید',
                                            'class' => 'form-control input-lg',
                                            'dir' => 'rtl',
                                            'tabindex' => '5',
                                        ]);
                                ?>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-6">
                                    <div class="form-group">
                                        <?=
                                        $form->field($userModel, 'password')->passwordInput([
                                            'class' => 'form-control input-lg',
                                            'dir' => 'rtl',
                                            'placeholder' => 'رمز ورود را وارد کنید ',
                                            'tabindex' => '4',
                                            'maxlength' => '30',
                                        ]);
                                        ?>  
                                    </div>
                                </div>
                            </div>
                            <div class="">
                                <div class="form-group">                                    
                                    <?= $form->field($userModel, 'status')->checkbox([
                                        'label' => 'وضعیت فعال بودن کاربر',
                                        'value' => '1' ,
                                        ])?>
                                </div>
                            </div>

                            <!--<hr class="colorgraph">-->
                            <div class="row">
                                <div class="col-xs-12 col-md-12">
                                    <?=
                                    Html::submitInput($valueBtn, [
                                        'class' => 'btn btn-success btn-block btn-lg',
                                        'tabindex' => '6',
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
<?php ActiveForm::end(); ?>