<?php
    
    echo $this->render('_formpersonnel',[
        'cardPersonnelModel' => $personnelModel,
        'title' => 'ویرایش کارت پرسنلی',
        'valueBtn' => 'ثبت ویرتیش',
        'data' => 'edit',
        'type' => $type,
    ]);

