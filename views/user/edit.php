<?php

    echo $this->render('_form',[
        'userModel' => $userModel,
        'levelArray' => $levelArray,
        'title' => 'ویرایش کاربر',
        'valueBtn' => 'ثبت ویرایش',
    ]);