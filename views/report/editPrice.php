<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>
<?php $form = ActiveForm::begin([
    'options' => [
        'data-pjax' => 1
    ]
]); ?>

    <?= $form->field($transactionModel, "price"); ?>
    <?= Html::submitButton('save', [
        'class' => 'btn'
    ]) ?>
<?php ActiveForm::end() ?>
