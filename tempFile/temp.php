<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
$this->title = 'ایجاد کارت';
?>

<div class="text-right">

    
    <div class="body-content">
        <div class="">
            <div class="col-xs-12 col-sm-8 col-md-8 col-md-offset-2 col-sm-offset-2">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="col-xs-12 col-sm-12 col-md-12 ">
                            <section class="section-tab">
                                <div class="tab">
                                    <div id="wrapper">
                                        <section id="generic-tabs">
                                            <ul id="tabs">			    
                                                <li>
                                                    <a title="Contact" href="#first-tab"><i class="fa fa-envelope"></i> کارت پرسنلی </a>	    
                                                </li>
                                                <li>
                                                    <a title="Photos" href="#second-tab"><i class="fa fa-picture-o"></i> کارت ویژه</a>	
                                                </li>
                                                <li>
                                                    <a title="About" href="#third-tab"><i class="fa fa-info-circle"></i>کارت تخفیف دار</a>	
                                                </li>
                                            </ul>
                                            <div id="first-tab" class="tab-content">        
                                                <section class="row">
                                                    <section class="panel-body">
                                                        <section class="col-xs-12 col-sm-12 col-md-12 ">
                                                            <section class="panel-body">
                                                                <section class="col-xs-12 col-sm-12 col-md-12 ">
                                                                        <form role="form">
                                                                                <h2>ثبت کارت پرسنلی <small>لطفا فیلدها را با دقت پر کنید</small></h2>
                                                                                <hr class="colorgraph">
                                                                                <section class="row">
                                                                                    
                                                                                </section>
                                                                        </form>
                                                                </section>
                                                            </section>
                                                        </section>
                                                    </section>
                                                </section>
                                            </div>

                                            <div id="second-tab" class="tab-content">     
                                                <section class="row">
                                                    <section class="panel-body">
                                                        <section class="col-xs-12 col-sm-12 col-md-12 ">
                                                                <form role="form">
                                                                        <h2>ثبت کارت ویژه <small>لطفا فیلدها را با دقت پر کنید</small></h2>
                                                                        <hr class="colorgraph">
                                                                        <section class="row">
                                                                            <section class="col-xs-12 col-sm-6 col-md-6">
                                                                                <section class="form-group">
                                                                                    <label for="name-new">نام مشتری </label>
                                                                                    <input type="text" name="" id="name-new" class="form-control input-lg" dir="rtl" placeholder="نام متقاضی را وارد کنید " tabindex="1">
                                                                                </section>
                                                                            </section>
                                                                            <section class="col-xs-12 col-sm-6 col-md-6">
                                                                                <section class="form-group">
                                                                                    <label for="username-new"> شماره تگ </label>
                                                                                    <input type="text" name="" id="username-new" class="form-control input-lg" dir="rtl" placeholder="شماره تگ را وارد کنید" tabindex="2">
                                                                                    </section>
                                                                            </section>
                                                                        </section>
                                                                        <section class="row">
                                                                            <section class="col-xs-12 col-sm-6 col-md-6">
                                                                                <section class="form-group">
                                                                                    <label for="name-new">مبلغ </label>
                                                                                    <input type="text" name="" id="name-new" class="form-control input-lg" dir="rtl" placeholder="هزینه استفاده از پارکینگ " tabindex="1">
                                                                                </section>
                                                                            </section>
                                                                            <section class="col-xs-12 col-sm-6 col-md-6">
                                                                                <section class="form-group">
                                                                                    <label for="username-new">کد ملی </label>
                                                                                    <input type="text" name="" id="username-new" class="form-control input-lg" dir="rtl" placeholder="کد ملی را وارد کنید" tabindex="2">
                                                                                    </section>
                                                                            </section>
                                                                        </section>
                                                                        <section class="row">
                                                                            <section class="col-xs-12 col-sm-6 col-md-3">
                                                                                <section class="form-group">
                                                                                    <label for="name-new">مدل خودرو </label>
                                                                                    <input type="text" name="" id="name-new" class="form-control input-lg" dir="rtl" placeholder="مشخصات " tabindex="1">
                                                                                </section>
                                                                            </section>
                                                                            <section class="col-xs-12 col-sm-6 col-md-3">
                                                                                <section class="form-group">
                                                                                    <label for="username-new">مدت استفاده </label>
                                                                                    <input type="text" name="" id="username-new" class="form-control input-lg" dir="rtl" placeholder="00" tabindex="2">
                                                                                    </section>
                                                                            </section>
                                                                            <section class="col-xs-12 col-sm-6 col-md-6">
                                                                                <section class="form-group">
                                                                                    <label for="username-new"> شماره پلاک خودرو </label>
                                                                                    <input type="text" name="" id="username-new" class="form-control input-lg" dir="rtl" placeholder="11-22-ب-222" tabindex="2">
                                                                                    </section>
                                                                            </section>
                                                                            
                                                                            <section class="form-group">
                                                                                <section class="col-xs-12 col-md-12"><input type="submit" value="ثبت کارت" class="btn btn-success btn-block btn-lg" tabindex="6"></section>
                                                                            </section>
                                                                            
                                                                        </section>
                                                                </form>
                                                        </section>
                                                    </section> 
                                                </section>
                                            </div>

                                            <div id="third-tab" class="tab-content">        
                                                <section class="row">
                                                    <section class="panel-body">
                                                        <section class="col-xs-12 col-sm-12 col-md-12 ">
                                                                <form role="form">
                                                                        <h2>ثبت کارت تخفیف دار <small>لطفا فیلدها را با دقت پر کنید</small></h2>
                                                                        <hr class="colorgraph">
                                                                        <section class="row">
                                                                            <section class="col-xs-12 col-sm-6 col-md-6">
                                                                            <section class="form-group">
                                                                                <label for="name-new">درصد تخفیف </label>
                                                                                <input type="text" name="" id="name-new" class="form-control input-lg" dir="rtl" placeholder="00 " tabindex="1">
                                                                            </section>

                                                                            </section>
                                                                            <section class="col-xs-12 col-sm-6 col-md-6">
                                                                                    <section class="form-group">
                                                                                        <label for="username-new"> شماره تگ </label>
                                                                                        <input type="text" name="" id="username-new" class="form-control input-lg" dir="rtl" placeholder="شماره تگ را وارد کنید" tabindex="2">
                                                                                    </section>
                                                                            </section>
                                                                            <section class="form-group">
                                                                                <section class="col-xs-12 col-md-12"><input type="submit" value="ثبت کارت" class="btn btn-success btn-block btn-lg" tabindex="6"></section>
                                                                            </section>
                                                                        </section>
                                                                </form>
                                                        </section>
                                                    </section> 
                                                </section>
                                            </div>
                                        </section>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>