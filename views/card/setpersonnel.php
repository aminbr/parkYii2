<?php
    
    echo $this->render('_formpersonnel',[
        'cardPersonnelModel' => $cardPersonnelModel,
        'title' => 'صدور کارت پرسنلی',
        'valueBtn' => 'ثبت کارت',
        'data' => 'create',
        'type' => 'register', 
    ]);

