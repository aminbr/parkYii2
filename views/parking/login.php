<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$this->title = 'ورود';
?>

<?php $form = ActiveForm::begin(); ?>
<div class="container">
    <div class="login-container">
        <div id="output"></div>
        <h4>ورود اعضا</h4>
            <hr class="colorgraph">  
        <div class="avatar">
            <img src="img/user-icon.png" />
        </div>
        <div class="form-box">
                <div class="input-group form-group">
                    <?= $form->field($model, "username")->textInput([
                        'class' => 'form-control input-lg',
                    ]); ?>
                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                </div>
                <div class="input-group form-group">
                    <?= $form->field($model, "password")->passwordInput([
                        'class' => 'form-control input-lg',
                    ]); ?>
                    <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                </div>
            <?= Html::submitInput('ورود' , [
                    'class' => 'btn btn-success input-lg input-block form-group'
                ]); ?>
        </div>
    </div>    
</div>


<?php ActiveForm::end(); ?>