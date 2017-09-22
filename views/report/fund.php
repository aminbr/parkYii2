<?php
use yii\grid\GridView;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$this->title = 'گزارش صندوق';
?>
<style>
    td,th{
        text-align: center;
    }
</style>
    <div class="body-content text-right">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="col-xs-12 col-sm-12 col-md-12 ">
                            <h2>گزارش برداشت از صندوق</h2>
                            <hr class="colorgraph">    
                            <?= GridView::widget([
                                    'dataProvider' => $dataProvider,
                                    'filterModel' => $cashRemovalModelSearch,
                                    'columns' => [
                                        [
                                            'attribute' => 'removal_amount',
                                            'value' => 'removal_amount',
                                        ],
                                        [
                                            'attribute' => 'nickname',
                                            'value' => function ($model) {
                                                if(isset($model->user)){
                                                    return $model->user->nickname;
                                                }
                                            }   
                                        ],
                                        [
                                            'attribute' => 'removal_time',
                                            'value' => function($model){
                                                $data = Yii::$app->utility->convertDate([
                                                    'to' => 'persian',
                                                    'time' => $model->removal_date,
                                                ]);
                                                return $data['hour'].' : '.$data['minute'].' : '.$data['second'];
                                            }
                                        ],
                                        [
                                            'attribute' => 'removal_date',
                                            'value' => function($model){
                                                $data = Yii::$app->utility->convertDate([
                                                    'to' => 'persian',
                                                    'time' => $model->removal_date,
                                                ]);
                                                return $data['year'].' / '.$data['month_num'].' / '.$data['day'];
                                            }
                                        ],
                                        
                                    ]
                                ])
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

<?php
//$this->registerJs(
//    "$('#txtAzFund').persianDatepicker({        
//        cellWidth: 22, 
//        cellHeight: 20,
//        fontSize: 16, 
//    });
//    $('#txtTaFund').persianDatepicker({        
//        cellWidth: 22, 
//        cellHeight: 20,
//        fontSize: 16, 
//    });"
//);
