<?php
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$this->title = 'گزارش کاربران';
?>
<style>
    th{
        text-align: right;
    }
</style>
<div class="text-right">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="col-xs-12 col-sm-12 col-md-12 "> 
                <h2>گزارش کاربران ثبت شده در سیستم</h2>
                <hr class="colorgraph">                        
                <!--<hr class="colorgraph">-->
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $userModelSearch,
                        'columns' => [
                            [
                                'header' => 'ویرایش',
                                'headerOptions' => ['style' => 'color:#337ab7'],
                                'class' => yii\grid\ActionColumn::className(),
                                'template' => "{update} {delete}",
                                'buttons' => [
                                    'update' => function($key, $model, $index)
                                    {
                                        return Html::a('<span class="glyphicon glyphicon-pencil" ></span>', Url::to(['/user/edituser', 'id' => $model->id]));
                                    }, 
                                    'delete' => function($key, $model, $index)
                                    {
                                        return Html::a('<span class="glyphicon glyphicon-trash" ></span> ', 
                                                Url::to(['/user/removeuser', 'id' => $model->id]), [
                                                    'onclick' => 'deleteUser(this); return false;'
                                                ]);
                                    }, 
                                ]
                            ],
                            [
                                'attribute' => 'level',
                                'filter' => ['1' => 'کاربر', '2' => 'حسابدار', '3' => 'مدیر'],
                                'value' => function($model,$key, $index){
                                    if($model->level == 1){
                                        return 'کاربر';
                                    }else if($model->level == 2){
                                        return 'حسابدار';
                                    }else if($model->level == 3){
                                        return 'مدیر';
                                    }
                                }
                            ],
                            [
                                'attribute' => 'status',
                                'filter' => ['0' => 'غیر فعال', '1' => 'فعال'],
                                'value' => function($model,$key, $index){
                                    if($model->status == 1){
                                        return 'فعال';
                                    }else if($model->status == 0){
                                        return 'غیر فعال';
                                    }
                                }
                            ],
                            [
                                'attribute' => 'email',
                                'value' => 'email',
                            ],
                            [
                                'attribute' => 'username',
                                'value' => 'username',
                            ],
                            [
                                'attribute' => 'nickname',
                                'value' => 'nickname',
                            ],
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
    function deleteUser(obj){
        var url = $(obj).attr('href');
        var res = confirm('آیا از حذف کاربر مطمئن هستید؟');
        if(res)
        {
            window.location=url;
        }
        return false;
    }
", yii\web\View::POS_END);



