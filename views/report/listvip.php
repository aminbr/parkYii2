<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
$this->title = 'گزارش کارت های ویژه';
?>
<style>
    th{
        text-align: right;
    }
    </style>
<div class="text-right">
    <div class="body-content">
        <div class="">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="col-xs-12 col-sm-12 col-md-12 "> 
                                <h2>گزارش کارت های ویژه در سیستم</h2>
                                <hr class="colorgraph">                        
                                <!--<hr class="colorgraph">-->
                                    <?php
                                    echo GridView::widget([
                                        'dataProvider' => $dataProvider,
                                        'filterModel' => $vipModelSearch,
                                        'columns' => [
                                            [
                                                'header' => 'ویرایش',
                                                'headerOptions' => ['style' => 'color:#337ab7'],
                                                'class' => yii\grid\ActionColumn::className(),
                                                'template' => "{update} {delete} {edit}",
                                                'buttons' => [
                                                    'edit' => function($key, $model, $index)
                                                    {
                                                        return Html::a('<span class="glyphicon glyphicon-pencil" ></span>',
                                                                Url::to(['/card/editvip', 'id' => $model->id]));
                                                    },
                                                    'update' => function($key, $model, $index)
                                                    {
                                                        return Html::a('<span class="glyphicon glyphicon-download-alt" ></span>',
                                                                Url::to(['/card/updatevip', 'id' => $model->id]));
                                                    }, 
                                                    'delete' => function($key, $model, $index)
                                                    {
                                                        return Html::a('<span class="glyphicon glyphicon-trash" ></span> ', 
                                                                Url::to(['/card/removevip', 'id' => $model->id]), [
                                                                    'onclick' => 'deleteVip(this); return false;'
                                                                ]);
                                                    }, 
                                                ]
                                            ],
                                            [
                                                'attribute' => 'name',
                                                'value' => 'name',
                                            ],
                                            [
                                                'attribute' => 'nt_code',
                                                'value' => 'nt_code',
                                            ],
                                            [
                                                'attribute' => 'days',
                                                'value' => 'days',
                                            ],
                                            [
                                                'attribute' => 'plate_car',
                                                'value' => 'plate_car',
                                            ],
                                            [
                                                'attribute' => 'model_car',
                                                'value' => 'model_car',
                                            ],
                                        ]
                                    ]);
                                    ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php

$this->registerJs(" 
    function deleteVip(obj){
        var url = $(obj).attr('href');
        var res = confirm('آیا از حذف کارت مطمئن هستید؟');
        if(res)
        {
            window.location=url;
        }
        return false;
    }
", yii\web\View::POS_END);



