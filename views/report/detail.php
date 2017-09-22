<?php
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Modal;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$this->title = 'گزارش تفضیلی';
?>
<style>
    td,th{
        text-align: center;
    }
</style>
<div class="body-content text-right">
    <div class="col-xs-12 col-sm-12 col-md-12 ">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="col-xs-12 col-sm-12 col-md-12 ">
                    <h2>گزارش تفضیلی</h2>
                    <hr class="colorgraph">   
                    
                <?php // die(var_dump($enterExitModelSearch));  ?>
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $enterExitModelSearch,
                        'columns' => [
                            [
                                'header' => 'ویرایش قیمت',
                                'headerOptions' => ['style' => 'color:#337ab7'],
                                'class' => yii\grid\ActionColumn::className(),
                                'template' => "{update} ",
                                'buttons' => 
                                [
                                    'update' => function($key, $model, $index)
                                    {
                                        if(Yii::$app->user->identity->level == 3) {
                                            return Html::a('<span class="glyphicon glyphicon-pencil" ></span>',
                                                    Url::to(['editprice', 'id' => $model->id]),[
                                                        'onclick' => 'showModal(this);return false;'
                                            ]);
                                        }else{
                                            return "عدم دسترسی";
                                        }
                                    },

                                ],
                            ],
                            [
                                'attribute' => 'price',
                                'header' => 'قیمت',
                                'value' => function($model){
                                    if(isset($model->transaction)){
                                        return number_format($model->transaction->price);
                                    }

                                }
                            ],
                            [
                                'header' => 'زمان پارک',
                                'value' => function($model){
                                    $time_park = $model->exit_date - $model->enter_date;
                                    $days = (int) ($time_park / (3600*24));
                                    $hours = (int) (($time_park % (3600*24)) / 3600);
                                    $minutes = (int) (($time_park % 3600) / 60);
                                    $sec1 = (int) ($time_park % 60);

                                    $result = str_pad($hours, 2, '0', STR_PAD_LEFT) . ':'
                                            . str_pad($minutes, 2, '0', STR_PAD_LEFT) . ':'
                                            . str_pad($sec1, 2, '0', STR_PAD_LEFT);

                                    if ($days > 0) {
                                          $result = "$days:" . $result;
                                    }

                                    return $result;
                                }
                            ],
                            [
                                'attribute' => 'exit_date',
                                'header' => 'ساعت خروج',
                                'value' => function($model){
                                    $data = Yii::$app->utility->convertDate([
                                        'to' => 'persian',
                                        'time' => $model->exit_date,
                                    ]);
                                    return $data['hour'].' : '.$data['minute'].' : '.$data['second'];
                                }
                            ],
                            [
                                'attribute' => 'exit_date',
                                'header' => 'تاریخ خروج',
                                'value' => function($model){
                                    $data = Yii::$app->utility->convertDate([
                                        'to' => 'persian',
                                        'time' => $model->exit_date,
                                    ]);
                                    return $data['year'].' / '.$data['month_num'].' / '.$data['day'];
                                }
                            ],
                            [
                                'attribute' => 'enter_date',
                                'header' => 'ساعت ورود',
                                'value' => function($model){
                                    $data = Yii::$app->utility->convertDate([
                                        'to' => 'persian',
                                        'time' => $model->enter_date,
                                    ]);
                                    return $data['hour'].' : '.$data['minute'].' : '.$data['second'];
                                }
                            ],
                            [
                                'attribute' => 'enter_date',
                                'header' => 'تاریخ ورود',
                                'value' => function($model){
                                    $data = Yii::$app->utility->convertDate([
                                        'to' => 'persian',
                                        'time' => $model->enter_date,
                                    ]);
                                    return $data['year'].' / '.$data['month_num'].' / '.$data['day'];
                                }
                            ],
                            [
                                'attribute' => 'nickname',
                                'value' => function($model){
                                    if(isset($model->user)){
                                        return $model->user->nickname;
                                    }
                                }
                            ],
                            [
                                'attribute' => 'type',
                                'value' => function($model){
                                    if(isset($model->card) && isset($model->card->cardType)){
                                        return $model->card->cardType->name;
                                    }
                                }
                            ],
                        ]
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
</div>


<?php
 Modal::begin([
     'id' => 'update-price-modal',
 ]);
 \yii\widgets\Pjax::begin(['id' => 'update-pjax']);
$this->registerJs("
    function showModal(obj)
    {
        var url = $(obj).attr('href');
        $.ajax({
            url:url
        })
        .done(function(data){
            $('#update-pjax').html(data);
            $('#update-price-modal').modal('show');
        });
        
        return false;
    }
    
    $('#update-pjax').on('pjax:success', function(){
        $('#update-price-modal').modal('hide');
        window.location = '".Yii::$app->urlManager->createAbsoluteUrl('report/detail')."';
    });
    ", yii\web\View::POS_END);
\yii\widgets\Pjax::end();
Modal::end();