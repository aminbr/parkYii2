<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\grid\GridView;
$form = ActiveForm::begin();
?>
    <div class="body-content text-right">
            <div class="col-xs-12 col-sm-12 col-md-12 ">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="col-xs-12 col-sm-12 col-md-12 ">
                            <h2>گزارش تفضیلی</h2>
                            <hr class="colorgraph">    
                            <?php // echo $time;?>
                            <div class="row">
                                <div class="col-xs-12 col-sm-4 col-md-2 col-md-offset-6">
                                    <label><span style="color: transparent; ">جستجو</span> </label>
                                <?= 
                                    Html::submitInput('جستجو', [
                                        'class' => 'btn btn-info input-lg btn-block form-control',
                                        'tabindex' => '3',
                                    ]); 
                                ?>
                                </div>
                                <div class="col-xs-12 col-sm-4 col-md-2 ">
                                <?= $form->field($financialReportModel, 'tillDateOf')->textInput([
                                    'class' => 'form-control input-lg',
                                    'dir' => 'rtl',
                                    'placeholder' => 'تا تاریخ',
                                    'tabindex' => '2',
                                    'maxlength' => '10',
                                    'value' => '1396/6/5',
                                ]); ?>
                                </div>
                                <div class="col-xs-12 col-sm-4 col-md-2 ">
                                <?= $form->field($financialReportModel, 'fromDate')->textInput([
                                    'class' => 'form-control input-lg',
                                    'dir' => 'rtl',
                                    'placeholder' => 'از تاریخ',
                                    'tabindex' => '1',
                                    'maxlength' => '10',
                                    'value' => '1396/6/5',
                                ]); ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <?= GridView::widget([
                                    'dataProvider' => $dataProvider,
                                    'columns' => [
                                        [
                                            'attribute' => 'price',
                                            'value' => 'price',
                                        ],
                                        [
                                            'attribute' => 'user_id',
                                            'value' => 'user_id',
                                        ],
                                    ]
                                ])
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

<?php ActiveForm::end(); ?>
