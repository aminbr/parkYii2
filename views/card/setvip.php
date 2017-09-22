<?php
    
    echo $this->render('_formvip',[
        'setVip' => $setVip,
        'title' => 'صدور کارت ویژه',
        'valueBtn' => 'ثبت کارت',
        'data' => 'create',
        'type' => 'register', 
    ]);

