<?php
use yii\helpers\Html;
$this->title = 'تنظیمات اولیه';
?>

<div class="text-right">
    <div class="body-content">
        <div class="">
            <div class="col-xs-12 col-sm-6 col-md-6 col-md-offset-3">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="col-xs-12 col-sm-8 col-md-12 ">
                            <h2>تنظیمات اولیه <small>لطفا فیلدها را با دقت پر کنید</small></h2>
                            <hr class="colorgraph">
                            <div class="row">
                                <div class="col-xs-12 col-sm-6 col-md-12">
                                    <div class="form-group">
                                        <?= Html::errorSummary($configModel); ?>
                                        <?= Html::beginForm(); ?>
                                        <?php foreach($setting['parking'] as $key => $value){ ?>
                                        <div class="form-group">
                                            <label><?= Yii::t('app', $key); ?></label>
                                            <?php if($key != 'free_time'): ?>
                                            <?= Html::textInput('Config['.$key.']', $setting['parking'][$key], [
                                                'class' => 'form-control input-lg',
                                                'dir' => 'rtl',
                                                'placeholder' => '0000',
                                                'maxlength' => '4',
                                                'type' => 'number',
                                            ])  ?>
                                            <?php endif; ?>
                                        </div>
                                        <?php } ?>
                                        <?= Html::dropDownList('Config[free_time]',$setting['parking']['free_time'], [
                                            '16.666' => '10 دقیقه',
                                            '25' => '15 دقیقه',
                                            '50' => '30 دقیقه',
                                        ], [
                                            'class' => 'form-control input-lg',
                                            'dir' => 'rtl',
                                        ]);
                                        ?>
                                        
                                    </div>
                                </div>
                                <div class="">
                                    <div class="col-xs-12 col-md-12">
                                        <?=
                                        Html::submitInput('ثبت تنظیمات', [
                                            'class' => 'btn btn-success btn-block btn-lg',
                                            'tabindex' => '5',
                                        ])
                                        ?>
                                    </div>
                                </div>
                                <?= Html::endForm(); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</div>
