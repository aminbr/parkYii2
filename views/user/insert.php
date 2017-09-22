<?php
    
    echo $this->render('_form',[
        'userModel' => $userModel,
        'levelArray' => $levelArray,
        'title' => 'ایجاد کاربر',
        'valueBtn' => 'ثبت کاربر',
    ]);

