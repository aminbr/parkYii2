<?php
    
    echo $this->render('_formvip',[
        'setVip' => $vipModel,
        'title' => 'ویرایش کارت ویژه',
        'valueBtn' => 'ثبت ویرایش',
        'data' => 'edit',
        'type' => $type,
    ]);

