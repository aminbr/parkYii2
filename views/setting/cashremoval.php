<?php
use yii\helpers\Url;
use yii\helpers\Html;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$this->title = 'برداشت پول';
?>
<div class="">

</div>
<div class="text-right">
    <div class="body-content">
        <div class="">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="col-xs-12 col-sm-12 col-md-12 ">
                            
                            <h2>برداشت از صندوق</h2>
                            <hr class="colorgraph">                        
                            <!--<hr class="colorgraph">-->
                            <table class="table table-bordered table-hover text-center">
                                <tr class="text-center">
                                    <th class="text-center">برداشت موجودی</th><th class="text-center">موجودی کاربر</th><th class="text-center">نام کاربر </th><th class="text-center">ردیف</th>
                                </tr>
                                <?php
                                        $i=1;
                                        foreach ($data as $row) {
                                            echo '<tr>';
//                                            var_dump($row);
                                            echo '<td>'.Html::a('',  Url::to(['setting/removecash',
                                                'userId' => $row['id'], 'balancedPrice' => $row['balancedPrice']
                                                ]),[
                                            'class' => 'glyphicon glyphicon-trash text-danger',
                                            ]).'</td>';
                                            echo '<td>'.intval($row['balancedPrice']).'</td>';
                                            echo '<td>'.$row['nickname'].'</td>';
                                            echo '<td>'.$i.'</td>';
                                            echo '</tr>';
                                            $i++;
                                        }
                                ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>