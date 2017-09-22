<?php
namespace app\components;

use Yii;
use yii\base\Component;
/**
 * Description of utility
 *
 * @author user
 */
class utility extends Component{
   
    
    public function getSetting() {
        $configModel = \app\models\Config::find()->all();
        $config = [];
        foreach ($configModel as $con)
        {
            $config[$con->mode][$con->key_config] = $con->value;
        }
        return $config;
    }
    
    
    public function getIp() {
        $configModel = \app\models\SettingSys::find()->one();
        return $configModel;
    }
    
    
    public function getUrl() {
        $urlCamera = \app\models\Camera::find()->one();
        return $urlCamera;
    }
    

    public function compute($login_time, $exit_time, $discountpercent) {
        $config = $this->getSetting();
        $price_hour = $config['parking']['price_hour'];
        $input_price = $config['parking']['input_price'];
        $rounding = $config['parking']['rounding_price'];
        $time_free = $config['parking']['free_time'];
        $free_time = $time_free/100;
        $hour = ($exit_time - $login_time) /60/60;
        
        if($hour < $free_time)
        {
            return 0;
        }
        else if($hour < 0.5 && $hour > $free_time)
        {
            return $input_price + $price_hour/2;
        }
        else if($hour < 1 && $hour > $free_time)
        {
            return $input_price + $price_hour;
        }
        $result = intval($hour * $price_hour)+$input_price;
        $percentPrice = $result- $result*$discountpercent/100.0;
        return round(($percentPrice/$rounding))*$rounding;
    }
    
    
    function getTimeSpanFromSeconds($sec) {
        $days = (int) ($sec / (3600*24));
        $hours = (int) (($sec % (3600*24)) / 3600);
        $minutes = (int) (($sec % 3600) / 60);
        $sec1 = (int) ($sec % 60);

        $result = str_pad($hours, 2, '0', STR_PAD_LEFT) . ':'
                        . str_pad($minutes, 2, '0', STR_PAD_LEFT) . ':'
                        . str_pad($sec1, 2, '0', STR_PAD_LEFT);

        if ($days > 0) {
              $result = "$days:" . $result;
        }

        return $result;
    }
    
    
    function save_pic($picture)
    {
        $getUrl = $this->getUrl();
        $url = $getUrl->url_capture; // => http://192.168.8.121/cgi-bin/viewer/video.jpg
        $img = "upload/{$picture}.jpeg";
//        die(var_dump($img));
        if (!$fp = curl_init($url)){
            return FALSE;
        }          
        else
        {
            curl_setopt($fp, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($fp, CURLOPT_HEADER, 1);
            curl_setopt($fp, CURLOPT_TIMEOUT, 2);
            $output = curl_exec($fp);
            $res = file_put_contents($img, $output);
            curl_close($fp);
            if($res){
                return true;
            }
            else{
                return false;
            }
        }
//        die(var_dump(file_exists($url))); // => false
//        die(var_dump(@file_get_contents($url))); // => false
//        
//        if ($file = @file_get_contents($url))
//        {
//            $res = file_put_contents($img, $file);
//            if($res){
//                return  true;
//            }
//            else{
//                return false;
//            }
//        }
    }
    
    
    
    
    
//    $url = 'http://admin:admin@192.168.8.121/cgi-bin/viewer/video.jpg';
//        $img = "upload/{$picture}.jpeg";
//        
//        if(!file_exists($url))
//        {
////            die(var_dump(file_get_contents($url)));
//            if ($file = @file_get_contents($url))
//            {
//                $res = file_put_contents($img, $file);
//                if($res){
//                    return  true;
//                }
//                else{
//                    return false;
//                }
//            }
//        }
////        die(var_dump($url));
//        return false;
      
    
    public function socket($msg, $port) {
        
        error_reporting(E_ALL);

        /* Allow the script to hang around waiting for connections. */
        set_time_limit(0);

        /* Turn on implicit output flushing so we see what we're getting
         * as it comes in. */
        ob_implicit_flush();
        
        $ipConfig = $this->getIp();
        
        $address = $ipConfig->ip;
        
        if (($sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP)) === false) {
            echo "socket_create() failed: reason: " . socket_strerror(socket_last_error()) . "\n";
        }

        socket_set_nonblock($sock);
        
        if (socket_bind($sock, $address, $port) === false) {
            echo "socket_bind() failed: reason: " . socket_strerror(socket_last_error($sock)) . "\n";
        }

        if (socket_listen($sock, 5) === false) {
            echo "socket_listen() failed: reason: " . socket_strerror(socket_last_error($sock)) . "\n";
        }
        $time = time();
        $timeout = 3;
        
        do {
            if (($msgsock = socket_accept($sock)) === false) {
//                echo "socket_accept() failed: reason: " . socket_strerror(socket_last_error($sock)) . "\n";
                if ((time() - $time) >= $timeout) {
                    socket_close($sock);
//                    print('timeout reached!');
                    break 1;
                }
                continue;
            }
            $msg = $msg;
            socket_write($msgsock, $msg, strlen($msg));
            do {
                if (false === ($buf = socket_read($msgsock, 2048, PHP_NORMAL_READ))) {
                    echo "socket_read() failed: reason: " . socket_strerror(socket_last_error($msgsock)) . "\n";
                    break 1;
                }
                if (!$buf = trim($buf)) {
                    continue;
                }
                if ($buf == 'quit') {
                    break;
                }
                if ($buf == 'shutdown') {
                    socket_close($msgsock);
                    break 2;
                } 
                
                $talkback = "PHP: You said '$buf'.\n";
                socket_write($msgsock, $talkback, strlen($talkback));
                echo "$buf\n";
            } while (true);
            socket_close($msgsock);
        } while (true);
    }
     
    public function convertDate($array){
		$time = $array['time'];
		if($array['to'] == 'persian')
		{
			 date_default_timezone_set("Asia/tehran");
		        $weekdays = array("ط´ظ†ط¨ظ‡" , "غŒع©ط´ظ†ط¨ظ‡" , "ط¯ظˆط´ظ†ط¨ظ‡" , "ط³ظ‡ ط´ظ†ط¨ظ‡" , "ع†ظ‡ط§ط±ط´ظ†ط¨ظ‡" , "ظ¾ظ†ط¬ ط´ظ†ط¨ظ‡" , "ط¬ظ…ط¹ظ‡");
		        $months = array("ظپط±ظˆط±ط¯غŒظ†" , "ط§ط±ط¯غŒط¨ظ‡ط³طھ" , "ط®ط±ط¯ط§ط¯" , "طھغŒط±" , "ظ…ط±ط¯ط§ط¯" , "ط´ظ‡ط±غŒظˆط±" ,
		            "ظ…ظ‡ط±" , "ط¢ط¨ط§ظ†" , "ط¢ط°ط±" , "ط¯غŒ" , "ط¨ظ‡ظ…ظ†" , "ط§ط³ظپظ†ط¯" );
		        $dayNumber = date("d" , $time);
		        $monthNumber = date("m" , $time);
		        $year = date("Y",$time);
		        $weekDayNumber = date("w" , $time);
		        $hour = date("G" , $time);
		        $minute = date("i" , $time);
		        $second = date("s" , $time);
		        switch ($monthNumber)
		        {
		            case 1:
		                ($dayNumber < 20) ? ($monthNumber=10) : ($monthNumber = 11);
		                ($dayNumber < 20) ? ($dayNumber+=10) : ($dayNumber -= 19);
		                break;
		            case 2:
		                ($dayNumber < 19) ? ($monthNumber =11) : ($monthNumber =12);
		                ($dayNumber < 19) ? ($dayNumber += 12) : ($dayNumber -= 18);
		                break;
		            case 3:
		                ($dayNumber < 21) ? ($monthNumber = 12) : ($monthNumber = 1);
		                ($dayNumber < 21) ? ($dayNumber += 10) : ($dayNumber -= 20);
		                break;
		            case 4:
		                ($dayNumber < 21) ? ($monthNumber = 1) : ($monthNumber = 2);
		                ($dayNumber < 21) ? ($dayNumber += 11) : ($dayNumber -= 20);
		                break;
		            case 5:
		            case 6:
		                ($dayNumber < 22) ? ($monthNumber -= 3) : ($monthNumber -= 2);
		                ($dayNumber < 22) ? ($dayNumber += 10) : ($dayNumber -= 21);
		                break;
		            case 7:
		            case 8:
		            case 9:
		                ($dayNumber < 23) ? ($monthNumber -= 3) : ($monthNumber -= 2);
		                ($dayNumber < 23) ? ($dayNumber += 9) : ($dayNumber -= 22);
		                break;
		            case 10:
		                ($dayNumber < 23) ? ($monthNumber = 7) : ($monthNumber = 8);
		                ($dayNumber < 23) ? ($dayNumber += 8) : ($dayNumber -= 22);
		                break;
		            case 11:
		            case 12:
		                ($dayNumber < 22) ? ($monthNumber -= 3) : ($monthNumber -= 2);
		                ($dayNumber < 22) ? ($dayNumber += 9) : ($dayNumber -= 21);
		                break;
		        }
		        $newDate['day'] = $dayNumber;
		        $newDate['month_num'] = $monthNumber;
		        $newDate['month_name'] = $months[$monthNumber - 1];
		        if(($monthNumber < 3) or (($monthNumber == 3) and ($dayNumber < 21)))
		            $newDate['year'] = $year - 621;
		        else
		            $newDate['year'] = $year - 621;
		        if($weekDayNumber == 6)
		            $newDate['weekday_num'] = 0;
		        else
		            $newDate['weekday_num'] = $weekDayNumber + 1;
		        $newDate['weekday_name'] = $weekdays[$newDate['weekday_num']];
		        $newDate['hour'] = $hour;
		        $newDate['minute'] = $minute;
		        $newDate['second'] = $second;
		        return $newDate;
		}
	}
        
    function jdate($format,$timestamp='',$none='',$time_zone='Asia/Tehran',$tr_num='fa'){

 $T_sec=0;/* <= ط±ظپط¹ ط®ط·ط§ظٹ ط²ظ…ط§ظ† ط³ط±ظˆط± طŒ ط¨ط§ ط§ط¹ط¯ط§ط¯ '+' ظˆ '-' ط¨ط± ط­ط³ط¨ ط«ط§ظ†ظٹظ‡ */

 if($time_zone!='local')date_default_timezone_set(($time_zone=='')?'Asia/Tehran':$time_zone);
 $ts=($timestamp=='' or $timestamp=='now')?time()+$T_sec:tr_num($timestamp)+$T_sec;
 $date=explode('_',date('H_i_j_n_O_P_s_w_Y',$ts));
 list($j_y,$j_m,$j_d)=gregorian_to_jalali($date[8],$date[3],$date[2]);
 $doy=($j_m<7)?(($j_m-1)*31)+$j_d-1:(($j_m-7)*30)+$j_d+185;
 $kab=($j_y%33%4-1==(int)($j_y%33*.05))?1:0;
 $sl=strlen($format);
 $out='';
 for($i=0; $i<$sl; $i++){
  $sub=substr($format,$i,1);
  if($sub=='\\'){
	$out.=substr($format,++$i,1);
	continue;
  }
  switch($sub){

	case'C':case'E':case'R':case'x':case'X':
	$out.='ظ†ط³ط®ظ‡ غŒ ط¬ط¯غŒط¯ : http://jdf.scr.ir';
	break;

	case'B':case'e':case'g':
	case'G':case'h':case'I':
	case'T':case'u':case'Z':
	$out.=date($sub,$ts);
	break;

	case'a':
	$out.=($date[0]<12)?'ظ‚.ط¸':'ط¨.ط¸';
	break;

	case'A':
	$out.=($date[0]<12)?'ظ‚ط¨ظ„ ط§ط² ط¸ظ‡ط±':'ط¨ط¹ط¯ ط§ط² ط¸ظ‡ط±';
	break;

	case'b':
	$out.=(int)(1+($j_m/3));
	break;

	case'c':
	$out.=$j_y.'/'.$j_m.'/'.$j_d.' طŒ'.$date[0].':'.$date[1].':'.$date[6].' '.$date[5];
	break;

	case'd':
	$out.=($j_d<10)?'0'.$j_d:$j_d;
	break;

	case'D':
	$out.=jdate_words(array('kh'=>$date[7]),' ');
	break;

	case'f':
	$out.=jdate_words(array('ff'=>$j_m),' ');
	break;

	case'F':
	$out.=jdate_words(array('mm'=>$j_m),' ');
	break;

	case'H':
	$out.=$date[0];
	break;

	case'i':
	$out.=$date[1];
	break;

	case'j':
	$out.=$j_d;
	break;

	case'J':
	$out.=jdate_words(array('rr'=>$j_d),' ');
	break;

	case'k';
	$out.=tr_num(100-(int)($doy/($kab+365)*1000)/10,$tr_num);
	break;

	case'K':
	$out.=tr_num((int)($doy/($kab+365)*1000)/10,$tr_num);
	break;

	case'l':
	$out.=jdate_words(array('rh'=>$date[7]),' ');
	break;

	case'L':
	$out.=$kab;
	break;

	case'm':
	$out.=($j_m>9)?$j_m:'0'.$j_m;
	break;

	case'M':
	$out.=jdate_words(array('km'=>$j_m),' ');
	break;

	case'n':
	$out.=$j_m;
	break;

	case'N':
	$out.=$date[7]+1;
	break;

	case'o':
	$jdw=($date[7]==6)?0:$date[7]+1;
	$dny=364+$kab-$doy;
	$out.=($jdw>($doy+3) and $doy<3)?$j_y-1:(((3-$dny)>$jdw and $dny<3)?$j_y+1:$j_y);
	break;

	case'O':
	$out.=$date[4];
	break;

	case'p':
	$out.=jdate_words(array('mb'=>$j_m),' ');
	break;

	case'P':
	$out.=$date[5];
	break;

	case'q':
	$out.=jdate_words(array('sh'=>$j_y),' ');
	break;

	case'Q':
	$out.=$kab+364-$doy;
	break;

	case'r':
	$key=jdate_words(array('rh'=>$date[7],'mm'=>$j_m));
	$out.=$date[0].':'.$date[1].':'.$date[6].' '.$date[4]
	.' '.$key['rh'].'طŒ '.$j_d.' '.$key['mm'].' '.$j_y;
	break;

	case's':
	$out.=$date[6];
	break;

	case'S':
	$out.='ط§ظ…';
	break;

	case't':
	$out.=($j_m!=12)?(31-(int)($j_m/6.5)):($kab+29);
	break;

	case'U':
	$out.=$ts;
	break;

	case'v':
	 $out.=jdate_words(array('ss'=>substr($j_y,2,2)),' ');
	break;

	case'V':
	$out.=jdate_words(array('ss'=>$j_y),' ');
	break;

	case'w':
	$out.=($date[7]==6)?0:$date[7]+1;
	break;

	case'W':
	$avs=(($date[7]==6)?0:$date[7]+1)-($doy%7);
	if($avs<0)$avs+=7;
	$num=(int)(($doy+$avs)/7);
	if($avs<4){
	 $num++;
	}elseif($num<1){
	 $num=($avs==4 or $avs==(($j_y%33%4-2==(int)($j_y%33*.05))?5:4))?53:52;
	}
	$aks=$avs+$kab;
	if($aks==7)$aks=0;
	$out.=(($kab+363-$doy)<$aks and $aks<3)?'01':(($num<10)?'0'.$num:$num);
	break;

	case'y':
	$out.=substr($j_y,2,2);
	break;

	case'Y':
	$out.=$j_y;
	break;

	case'z':
	$out.=$doy;
	break;

	default:$out.=$sub;
  }
 }
 return($tr_num!='en')?tr_num($out,'fa','.'):$out;
}

/*	F	*/
function jstrftime($format,$timestamp='',$none='',$time_zone='Asia/Tehran',$tr_num='fa'){

 $T_sec=0;/* <= ط±ظپط¹ ط®ط·ط§ظٹ ط²ظ…ط§ظ† ط³ط±ظˆط± طŒ ط¨ط§ ط§ط¹ط¯ط§ط¯ '+' ظˆ '-' ط¨ط± ط­ط³ط¨ ط«ط§ظ†ظٹظ‡ */

 if($time_zone!='local')date_default_timezone_set(($time_zone=='')?'Asia/Tehran':$time_zone);
 $ts=($timestamp=='' or $timestamp=='now')?time()+$T_sec:$this->tr_num($timestamp)+$T_sec;
 $date=explode('_',date('h_H_i_j_n_s_w_Y',$ts));
 list($j_y,$j_m,$j_d)=gregorian_to_jalali($date[7],$date[4],$date[3]);
 $doy=($j_m<7)?(($j_m-1)*31)+$j_d-1:(($j_m-7)*30)+$j_d+185;
 $kab=($j_y%33%4-1==(int)($j_y%33*.05))?1:0;
 $sl=strlen($format);
 $out='';
 for($i=0; $i<$sl; $i++){
  $sub=substr($format,$i,1);
  if($sub=='%'){
	$sub=substr($format,++$i,1);
  }else{
	$out.=$sub;
	continue;
  }
  switch($sub){

	/* Day */
	case'a':
	$out.=jdate_words(array('kh'=>$date[6]),' ');
	break;

	case'A':
	$out.=jdate_words(array('rh'=>$date[6]),' ');
	break;

	case'd':
	$out.=($j_d<10)?'0'.$j_d:$j_d;
	break;

	case'e':
	$out.=($j_d<10)?' '.$j_d:$j_d;
	break;

	case'j':
	$out.=str_pad($doy+1,3,0,STR_PAD_LEFT);
	break;

	case'u':
	$out.=$date[6]+1;
	break;

	case'w':
	$out.=($date[6]==6)?0:$date[6]+1;
	break;

	/* Week */
	case'U':
	$avs=(($date[6]<5)?$date[6]+2:$date[6]-5)-($doy%7);
	if($avs<0)$avs+=7;
	$num=(int)(($doy+$avs)/7)+1;
	if($avs>3 or $avs==1)$num--;
	$out.=($num<10)?'0'.$num:$num;
	break;

	case'V':
	$avs=(($date[6]==6)?0:$date[6]+1)-($doy%7);
	if($avs<0)$avs+=7;
	$num=(int)(($doy+$avs)/7);
	if($avs<4){
	 $num++;
	}elseif($num<1){
	 $num=($avs==4 or $avs==(($j_y%33%4-2==(int)($j_y%33*.05))?5:4))?53:52;
	}
	$aks=$avs+$kab;
	if($aks==7)$aks=0;
	$out.=(($kab+363-$doy)<$aks and $aks<3)?'01':(($num<10)?'0'.$num:$num);
	break;

	case'W':
	$avs=(($date[6]==6)?0:$date[6]+1)-($doy%7);
	if($avs<0)$avs+=7;
	$num=(int)(($doy+$avs)/7)+1;
	if($avs>3)$num--;
	$out.=($num<10)?'0'.$num:$num;
	break;

	/* Month */
	case'b':
	case'h':
	$out.=jdate_words(array('km'=>$j_m),' ');
	break;

	case'B':
	$out.=jdate_words(array('mm'=>$j_m),' ');
	break;

	case'm':
	$out.=($j_m>9)?$j_m:'0'.$j_m;
	break;

	/* Year */
	case'C':
	$out.=substr($j_y,0,2);
	break;

	case'g':
	$jdw=($date[6]==6)?0:$date[6]+1;
	$dny=364+$kab-$doy;
	$out.=substr(($jdw>($doy+3) and $doy<3)?$j_y-1:(((3-$dny)>$jdw and $dny<3)?$j_y+1:$j_y),2,2);
	break;	

	case'G':
	$jdw=($date[6]==6)?0:$date[6]+1;
	$dny=364+$kab-$doy;
	$out.=($jdw>($doy+3) and $doy<3)?$j_y-1:(((3-$dny)>$jdw and $dny<3)?$j_y+1:$j_y);
	break;

	case'y':
	$out.=substr($j_y,2,2);
	break;

	case'Y':
	$out.=$j_y;
	break;

	/* Time */
	case'H':
	$out.=$date[1];
	break;

	case'I':
	$out.=$date[0];
	break;

	case'l':
	$out.=($date[0]>9)?$date[0]:' '.(int)$date[0];
	break;

	case'M':
	$out.=$date[2];
	break;

	case'p':
	$out.=($date[1]<12)?'ظ‚ط¨ظ„ ط§ط² ط¸ظ‡ط±':'ط¨ط¹ط¯ ط§ط² ط¸ظ‡ط±';
	break;

	case'P':
	$out.=($date[1]<12)?'ظ‚.ط¸':'ط¨.ط¸';
	break;

	case'r':
	$out.=$date[0].':'.$date[2].':'.$date[5].' '.(($date[1]<12)?'ظ‚ط¨ظ„ ط§ط² ط¸ظ‡ط±':'ط¨ط¹ط¯ ط§ط² ط¸ظ‡ط±');
	break;

	case'R':
	$out.=$date[1].':'.$date[2];
	break;

	case'S':
	$out.=$date[5];
	break;

	case'T':
	$out.=$date[1].':'.$date[2].':'.$date[5];
	break;

	case'X':
	$out.=$date[0].':'.$date[2].':'.$date[5];
	break;

	case'z':
	$out.=date('O',$ts);
	break;

	case'Z':
	$out.=date('T',$ts);
	break;

	/* Time and Date Stamps */
	case'c':
	$key=jdate_words(array('rh'=>$date[6],'mm'=>$j_m));
	$out.=$date[1].':'.$date[2].':'.$date[5].' '.date('P',$ts)
	.' '.$key['rh'].'طŒ '.$j_d.' '.$key['mm'].' '.$j_y;
	break;

	case'D':
	$out.=substr($j_y,2,2).'/'.(($j_m>9)?$j_m:'0'.$j_m).'/'.(($j_d<10)?'0'.$j_d:$j_d);
	break;

	case'F':
	$out.=$j_y.'-'.(($j_m>9)?$j_m:'0'.$j_m).'-'.(($j_d<10)?'0'.$j_d:$j_d);
	break;

	case's':
	$out.=$ts;
	break;

	case'x':
	$out.=substr($j_y,2,2).'/'.(($j_m>9)?$j_m:'0'.$j_m).'/'.(($j_d<10)?'0'.$j_d:$j_d);
	break;

	/* Miscellaneous */
	case'n':
	$out.="\n";
	break;

	case't':
	$out.="\t";
	break;

	case'%':
	$out.='%';
	break;

	default:$out.=$sub;
  }
 }
 return($tr_num!='en')?tr_num($out,'fa','.'):$out;
}

/*	F	*/
function jmktime($h='',$m='',$s='',$jm='',$jd='',$jy='',$is_dst=-1){
 $h=tr_num($h); $m=tr_num($m); $s=tr_num($s);
 if($h=='' and $m=='' and $s=='' and $jm=='' and $jd=='' and $jy==''){
	return mktime();
 }else{
	list($year,$month,$day)=jalali_to_gregorian($jy,$jm,$jd);
	return mktime($h,$m,$s,$month,$day,$year,$is_dst);
 }
}

/*	F	*/
function jgetdate($timestamp='',$none='',$tz='Asia/Tehran',$tn='en'){
 $ts=($timestamp=='')?time():tr_num($timestamp);
 $jdate=explode('_',jdate('F_G_i_j_l_n_s_w_Y_z',$ts,'',$tz,$tn));
 return array(
	'seconds'=>tr_num((int)tr_num($jdate[6]),$tn),
	'minutes'=>tr_num((int)tr_num($jdate[2]),$tn),
	'hours'=>$jdate[1],
	'mday'=>$jdate[3],
	'wday'=>$jdate[7],
	'mon'=>$jdate[5],
	'year'=>$jdate[8],
	'yday'=>$jdate[9],
	'weekday'=>$jdate[4],
	'month'=>$jdate[0],
	0=>tr_num($ts,$tn)
 );
}

/*	F	*/
function jcheckdate($jm,$jd,$jy){
 $jm=tr_num($jm); $jd=tr_num($jd); $jy=tr_num($jy);
 $l_d=($jm==12)?(($jy%33%4-1==(int)($jy%33*.05))?30:29):31-(int)($jm/6.5);
 return($jm>0 and $jd>0 and $jy>0 and $jm<13 and $jd<=$l_d)?true:false;
}

/*	F	*/
function tr_num($str,$mod='en',$mf='ظ«'){
 $num_a=array('0','1','2','3','4','5','6','7','8','9','.');
 $key_a=array('غ°','غ±','غ²','غ³','غ´','غµ','غ¶','غ·','غ¸','غ¹',$mf);
 return($mod=='fa')?str_replace($num_a,$key_a,$str):str_replace($key_a,$num_a,$str);
}

/*	F	*/
function jdate_words($array,$mod=''){
 foreach($array as $type=>$num){
  $num=(int)tr_num($num);
  switch($type){

	case'ss':
	$sl=strlen($num);
	$xy3=substr($num,2-$sl,1);
	$h3=$h34=$h4='';
	if($xy3==1){
	 $p34='';
	 $k34=array('ط¯ظ‡','غŒط§ط²ط¯ظ‡','ط¯ظˆط§ط²ط¯ظ‡','ط³غŒط²ط¯ظ‡','ع†ظ‡ط§ط±ط¯ظ‡','ظ¾ط§ظ†ط²ط¯ظ‡','ط´ط§ظ†ط²ط¯ظ‡','ظ‡ظپط¯ظ‡','ظ‡ط¬ط¯ظ‡','ظ†ظˆط²ط¯ظ‡');
	 $h34=$k34[substr($num,2-$sl,2)-10];
	}else{
	 $xy4=substr($num,3-$sl,1);
	 $p34=($xy3==0 or $xy4==0)?'':' ظˆ ';
	 $k3=array('','','ط¨غŒط³طھ','ط³غŒ','ع†ظ‡ظ„','ظ¾ظ†ط¬ط§ظ‡','ط´طµطھ','ظ‡ظپطھط§ط¯','ظ‡ط´طھط§ط¯','ظ†ظˆط¯');
	 $h3=$k3[$xy3];
	 $k4=array('','غŒع©','ط¯ظˆ','ط³ظ‡','ع†ظ‡ط§ط±','ظ¾ظ†ط¬','ط´ط´','ظ‡ظپطھ','ظ‡ط´طھ','ظ†ظ‡');
	 $h4=$k4[$xy4];
	}
	$array[$type]=(($num>99)?str_ireplace(array('12','13','14','19','20')
	,array('ظ‡ط²ط§ط± ظˆ ط¯ظˆغŒط³طھ','ظ‡ط²ط§ط± ظˆ ط³غŒطµط¯','ظ‡ط²ط§ط± ظˆ ع†ظ‡ط§ط±طµط¯','ظ‡ط²ط§ط± ظˆ ظ†ظ‡طµط¯','ط¯ظˆظ‡ط²ط§ط±')
	,substr($num,0,2)).((substr($num,2,2)=='00')?'':' ظˆ '):'').$h3.$p34.$h34.$h4;
	break;

	case'mm':
	$key=array
	('ظپط±ظˆط±ط¯غŒظ†','ط§ط±ط¯غŒط¨ظ‡ط´طھ','ط®ط±ط¯ط§ط¯','طھغŒط±','ظ…ط±ط¯ط§ط¯','ط´ظ‡ط±غŒظˆط±','ظ…ظ‡ط±','ط¢ط¨ط§ظ†','ط¢ط°ط±','ط¯غŒ','ط¨ظ‡ظ…ظ†','ط§ط³ظپظ†ط¯');
	$array[$type]=$key[$num-1];
	break;

	case'rr':
	$key=array('غŒع©','ط¯ظˆ','ط³ظ‡','ع†ظ‡ط§ط±','ظ¾ظ†ط¬','ط´ط´','ظ‡ظپطھ','ظ‡ط´طھ','ظ†ظ‡','ط¯ظ‡','غŒط§ط²ط¯ظ‡','ط¯ظˆط§ط²ط¯ظ‡','ط³غŒط²ط¯ظ‡',
	'ع†ظ‡ط§ط±ط¯ظ‡','ظ¾ط§ظ†ط²ط¯ظ‡','ط´ط§ظ†ط²ط¯ظ‡','ظ‡ظپط¯ظ‡','ظ‡ط¬ط¯ظ‡','ظ†ظˆط²ط¯ظ‡','ط¨غŒط³طھ','ط¨غŒط³طھ ظˆ غŒع©','ط¨غŒط³طھ ظˆ ط¯ظˆ','ط¨غŒط³طھ ظˆ ط³ظ‡',
	'ط¨غŒط³طھ ظˆ ع†ظ‡ط§ط±','ط¨غŒط³طھ ظˆ ظ¾ظ†ط¬','ط¨غŒط³طھ ظˆ ط´ط´','ط¨غŒط³طھ ظˆ ظ‡ظپطھ','ط¨غŒط³طھ ظˆ ظ‡ط´طھ','ط¨غŒط³طھ ظˆ ظ†ظ‡','ط³غŒ','ط³غŒ ظˆ غŒع©');
	$array[$type]=$key[$num-1];
	break;

	case'rh':
	$key=array('غŒع©ط´ظ†ط¨ظ‡','ط¯ظˆط´ظ†ط¨ظ‡','ط³ظ‡ ط´ظ†ط¨ظ‡','ع†ظ‡ط§ط±ط´ظ†ط¨ظ‡','ظ¾ظ†ط¬ط´ظ†ط¨ظ‡','ط¬ظ…ط¹ظ‡','ط´ظ†ط¨ظ‡');
	$array[$type]=$key[$num];
	break;

	case'sh':
	$key=array('ظ…ط§ط±','ط§ط³ط¨','ع¯ظˆط³ظپظ†ط¯','ظ…غŒظ…ظˆظ†','ظ…ط±ط؛','ط³ع¯','ط®ظˆع©','ظ…ظˆط´','ع¯ط§ظˆ','ظ¾ظ„ظ†ع¯','ط®ط±ع¯ظˆط´','ظ†ظ‡ظ†ع¯');
	$array[$type]=$key[$num%12];
	break;

	case'mb':
	$key=array('ط­ظ…ظ„','ط«ظˆط±','ط¬ظˆط²ط§','ط³ط±ط·ط§ظ†','ط§ط³ط¯','ط³ظ†ط¨ظ„ظ‡','ظ…غŒط²ط§ظ†','ط¹ظ‚ط±ط¨','ظ‚ظˆط³','ط¬ط¯غŒ','ط¯ظ„ظˆ','ط­ظˆطھ');
	$array[$type]=$key[$num-1];
	break;

	case'ff':
	$key=array('ط¨ظ‡ط§ط±','طھط§ط¨ط³طھط§ظ†','ظ¾ط§غŒغŒط²','ط²ظ…ط³طھط§ظ†');
	$array[$type]=$key[(int)(1+($num/3))-1];
	break;

	case'km':
	$key=array('ظپط±','ط§ط±','ط®ط±','طھغŒâ€چ','ظ…ط±','ط´ظ‡â€چ','ظ…ظ‡â€چ','ط¢ط¨â€چ','ط¢ط°','ط¯غŒ','ط¨ظ‡â€چ','ط§ط³â€چ');
	$array[$type]=$key[$num-1];
	break;

	case'kh':
	$key=array('غŒ','ط¯','ط³','ع†','ظ¾','ط¬','ط´');
	$array[$type]=$key[$num];
	break;

	default:$array[$type]=$num;
  }
 }
 return($mod=='')?$array:implode($mod,$array);
}

/** Convertor from and to Gregorian and Jalali (Hijri_Shamsi,Solar) Functions
Copyright(C)2011, Reza Gholampanahi [ http://jdf.scr.ir/jdf ] version 2.50 */

/*	F	*/
function gregorian_to_jalali($g_y,$g_m,$g_d,$mod=''){
	$g_y=tr_num($g_y); $g_m=tr_num($g_m); $g_d=tr_num($g_d);/* <= :ط§ظٹظ† ط³ط·ط± طŒ ط¬ط²ط، طھط§ط¨ط¹ ط§طµظ„ظٹ ظ†ظٹط³طھ */
 $d_4=$g_y%4;
 $g_a=array(0,0,31,59,90,120,151,181,212,243,273,304,334);
 $doy_g=$g_a[(int)$g_m]+$g_d;
 if($d_4==0 and $g_m>2)$doy_g++;
 $d_33=(int)((($g_y-16)%132)*.0305);
 $a=($d_33==3 or $d_33<($d_4-1) or $d_4==0)?286:287;
 $b=(($d_33==1 or $d_33==2) and ($d_33==$d_4 or $d_4==1))?78:(($d_33==3 and $d_4==0)?80:79);
 if((int)(($g_y-10)/63)==30){$a--;$b++;}
 if($doy_g>$b){
  $jy=$g_y-621; $doy_j=$doy_g-$b;
 }else{
  $jy=$g_y-622; $doy_j=$doy_g+$a;
 }
 if($doy_j<187){
  $jm=(int)(($doy_j-1)/31); $jd=$doy_j-(31*$jm++);
 }else{
  $jm=(int)(($doy_j-187)/30); $jd=$doy_j-186-($jm*30); $jm+=7;
 }
 return($mod=='')?array($jy,$jm,$jd):$jy.$mod.$jm.$mod.$jd;
}

/*	F	*/
function jalali_to_gregorian($j_y,$j_m,$j_d,$mod=''){
	$g_y=tr_num($j_y); $j_m=tr_num($j_m); $j_d=tr_num($j_d);/* <= :ط§ظٹظ† ط³ط·ط± طŒ ط¬ط²ط، طھط§ط¨ط¹ ط§طµظ„ظٹ ظ†ظٹط³طھ */
 $d_4=($j_y+1)%4;
 $doy_j=($j_m<7)?(($j_m-1)*31)+$j_d:(($j_m-7)*30)+$j_d+186;
 $d_33=(int)((($j_y-55)%132)*.0305);
 $a=($d_33!=3 and $d_4<=$d_33)?287:286;
 $b=(($d_33==1 or $d_33==2) and ($d_33==$d_4 or $d_4==1))?78:(($d_33==3 and $d_4==0)?80:79);
 if((int)(($j_y-19)/63)==20){$a--;$b++;}
 if($doy_j<=$a){
  $gy=$j_y+621; $gd=$doy_j+$b;
 }else{
  $gy=$j_y+622; $gd=$doy_j-$a;
 }
 foreach(array(0,31,($gy%4==0)?29:28,31,30,31,30,31,31,30,31,30,31) as $gm=>$v){
  if($gd<=$v)break;
  $gd-=$v;
 }
 return($mod=='')?array($gy,$gm,$gd):$gy.$mod.$gm.$mod.$gd;
}






/** Gregorian & Jalali (Hijri_Shamsi,Solar) Date Converter Functions
Author: JDF.SCR.IR =>> Download Full Version : http://jdf.scr.ir/jdf
License: GNU/LGPL _ Open Source & Free _ Version: 2.72 : [2017=1396]
--------------------------------------------------------------------
1461 = 365*4 + 4/4   &  146097 = 365*400 + 400/4 - 400/100 + 400/400
12053 = 365*33 + 32/4    &    36524 = 365*100 + 100/4 - 100/100   */


function gregorian_to_jalali_date($gy,$gm,$gd,$mod=''){
 $g_d_m=array(0,31,59,90,120,151,181,212,243,273,304,334);
 if($gy>1600){
  $jy=979;
  $gy-=1600;
 }else{
  $jy=0;
  $gy-=621;
 }
 $gy2=($gm>2)?($gy+1):$gy;
 $days=(365*$gy) +((int)(($gy2+3)/4)) -((int)(($gy2+99)/100)) +((int)(($gy2+399)/400)) -80 +$gd +$g_d_m[$gm-1];
 $jy+=33*((int)($days/12053)); 
 $days%=12053;
 $jy+=4*((int)($days/1461));
 $days%=1461;
 if($days > 365){
  $jy+=(int)(($days-1)/365);
  $days=($days-1)%365;
 }
 $jm=($days < 186)?1+(int)($days/31):7+(int)(($days-186)/30);
 $jd=1+(($days < 186)?($days%31):(($days-186)%30));
 return($mod=='')?array($jy,$jm,$jd):$jy.$mod.$jm.$mod.$jd;
}


function jalali_to_gregorian_date($jy,$jm,$jd,$mod=''){
 if($jy>979){
  $gy=1600;
  $jy-=979;
 }else{
  $gy=621;
 }
 $days=(365*$jy) +(((int)($jy/33))*8) +((int)((($jy%33)+3)/4)) +78 +$jd +(($jm<7)?($jm-1)*31:(($jm-7)*30)+186);
 $gy+=400*((int)($days/146097));
 $days%=146097;
 if($days > 36524){
  $gy+=100*((int)(--$days/36524));
  $days%=36524;
  if($days >= 365)$days++;
 }
 $gy+=4*((int)($days/1461));
 $days%=1461;
 if($days > 365){
  $gy+=(int)(($days-1)/365);
  $days=($days-1)%365;
 }
 $gd=$days+1;
 foreach(array(0,31,(($gy%4==0 and $gy%100!=0) or ($gy%400==0))?29:28 ,31,30,31,30,31,31,30,31,30,31) as $gm=>$v){
  if($gd<=$v)break;
  $gd-=$v;
 }
 return($mod=='')?array($gy,$gm,$gd):$gy.$mod.$gm.$mod.$gd; 
}









function jd_to_greg($julian) { 
    $julian = $julian - 1721119; 
    $calc1 = 4 * $julian - 1; 
    $year = floor($calc1 / 146097); 
    $julian = floor($calc1 - 146097 * $year); 
    $day = floor($julian / 4); 
    $calc2 = 4 * $day + 3; 
    $julian = floor($calc2 / 1461); 
    $day = $calc2 - 1461 * $julian; 
    $day = floor(($day + 4) / 4); 
    $calc3 = 5 * $day - 3; 
    $month = floor($calc3 / 153); 
    $day = $calc3 - 153 * $month; 
    $day = floor(($day + 5) / 5); 
    $year = 100 * $year + $julian; 

    if ($month < 10) { 
        $month = $month + 3; 
    } 
    else { 
        $month = $month - 9; 
        $year = $year + 1; 
    } 
    return "$day.$month.$year"; 
} 
}
