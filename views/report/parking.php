<?php
use yii\grid\GridView;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'گزارش پارکینگ';
?>
<style>
    td,th{
        text-align: center;
    }
    .img-car{
        transition: 1s;
        width: 50px;
        height: 20px;
    }
    .img-car:hover{
        transition: 1s;
        width: 850px;
        height: 700px;
    }
</style>
    <div class="body-content text-right">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="col-xs-12 col-sm-12 col-md-12 ">
                            <h2>گزارش خودروهای درون پارکینگ </h2>
                            <hr class="colorgraph">
                            <?= GridView::widget([
                                'dataProvider' => $dataProvider,
                                'columns' => [
                                    [
                                        'header' => 'خروج دستی',
                                        'headerOptions' => ['style' => 'color:#337ab7'],
                                        'class' => yii\grid\ActionColumn::className(),
                                        'template' => " {exit}",
                                        'buttons' => [ 
                                            'exit' => function($key, $model, $index)
                                            {
                                                return Html::a('<span class="glyphicon glyphicon-new-window text-danger" ></span> ', 
                                                Url::to(['/report/exitcar', 'id' => $model->id]), [
                                                    'onclick' => 'exitCar(this); return false;'
                                                ]);
                                            }, 
                                        ],
                                    ],
                                    [
                                        'attribute' => 'enter_photo',
                                        'format' => 'html',
                                        'value' => function($model) {
                                            return Html::img(Yii::$app->urlManager->baseUrl.'/upload/'.$model->enter_photo.'.jpeg' ,[
                                                'class' => 'img-car',
                                            ]);
                                        },
                                    ],
                                    [
                                        'attribute' => 'type',
                                        'value' => function($model) {
                                            return $model->card->cardType->name;
                                        }
                                    ],
                                    [
                                        'attribute' => 'nickname',
                                        'value' => function($model) {
                                            return $model->user->nickname;
                                        }
                                    ],
                                    [
                                        'attribute' => 'enter_time',
                                        'value' => function ($model) {
                                                $data = Yii::$app->utility->convertDate([
                                                    'to' => 'persian',
                                                    'time' => $model->enter_date,
                                                ]);
                                                return $data['hour'].':'.$data['minute'].':'.$data['second'];
                                        }
                                    ],
                                    [
                                        'attribute' => 'enter_date',
                                        'value' => function ($model) {
                                                $data = Yii::$app->utility->convertDate([
                                                    'to' => 'persian',
                                                    'time' => $model->enter_date,
                                                ]);
                                                return $data['year'].'/'.$data['month_num'].'/'.$data['day'];
                                        }
                                    ]
                                ]
                            ]);
                                
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>


<?php

$this->registerJs(" 
    function exitCar(obj){
        var url = $(obj).attr('href');
        var res = confirm('آیا از خروج خودرو اطمینان دارید؟');
        if(res)
        {
            window.location=url;
        }
        return false;
    }
", yii\web\View::POS_END);