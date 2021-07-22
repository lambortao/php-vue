<?php

//数据表前缀处理
function prefix_db($table_name){
	$CI =& get_instance();
	if (in_array($table_name, $CI->config->item("db_except")) == FALSE ){
		$table_name=$CI->config->item("db_lang").$table_name;
	}else{
		$table_name="db_".$table_name;
	}
	return $table_name;
}

//多维数组过滤相同值
function multi_unique($array) {
	if(!count($array)){return ($array);};
	foreach ($array as $k=>$na)
		$new[$k] = serialize($na);
	$uniq = array_unique($new);
	foreach($uniq as $k=>$ser)
		$new1[$k] = unserialize($ser);
	return ($new1);
}
//返回json结果并退出
function json_result($arr){
	echo json_encode($arr);
	exit();
}
//备份数据库
function front_create_backup($c_date,$c_cycle){

	if($c_cycle==1){
		$times=24*3600;
	}else if($c_cycle==2){
		$times=7*24*3600;
	}else if($c_cycle==3){
		$times=30*24*3600;
	}
	$preTime=strtotime($c_date)+$times;
	$nowTime=strtotime(date("Y-m-d H:i:s"));

	if($nowTime<$preTime) return false;

	@$_SESSION["backup"]=TRUE;
	@session_write_close();
	return @file_get_contents(base_url('admin_oms.php/api/create_backup')."/".session_id());
}

//获取ip地址
function getIp(){
	if(!empty($_SERVER["HTTP_CLIENT_IP"])){
	  $cip = $_SERVER["HTTP_CLIENT_IP"];
	}
	elseif(!empty($_SERVER["HTTP_X_FORWARDED_FOR"])){
	  $cip = $_SERVER["HTTP_X_FORWARDED_FOR"];
	}
	elseif(!empty($_SERVER["REMOTE_ADDR"])){
	  $cip = $_SERVER["REMOTE_ADDR"];
	}
	else{
	  $cip = "noip";
	}
	return $cip;
}

//根据IP获取省份信息
function getIpLookup($ip = ''){
	if(empty($ip)){
		return 'noip';
	}
	$res = @file_get_contents('http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=js&ip=' . $ip);
	if(empty($res)){ return false; }
	$jsonMatches = array();
	preg_match('#\{.+?\}#', $res, $jsonMatches);
	if(!isset($jsonMatches[0])){ return false; }
	$json = json_decode($jsonMatches[0], true);
	if(isset($json['ret']) && $json['ret'] == 1){
		$json['ip'] = $ip;
		unset($json['ret']);
	}else{
		return false;
	}
	return $json;
}


//截字符串
function limit_to_numwords($string, $numwords){
	$excerpt = explode(' ', $string, $numwords + 1);
	if (count($excerpt) >= $numwords) {
		array_pop($excerpt);
	}
	$excerpt = implode(' ', $excerpt);
	return $excerpt;
}

//删除特殊字符
function strFilter($str){
    $str = str_replace('`', '', $str);
    $str = str_replace('?', '', $str);
    $str = str_replace('~', '', $str);
    $str = str_replace('!', '', $str);
    $str = str_replace('！', '', $str);
    $str = str_replace('@', '', $str);
    $str = str_replace('#', '', $str);
    $str = str_replace('$', '', $str);
    $str = str_replace('￥', '', $str);
    $str = str_replace('%', '', $str);
    $str = str_replace('^', '', $str);
    $str = str_replace('……', '', $str);
    $str = str_replace('&', '', $str);
    $str = str_replace('*', '', $str);
    $str = str_replace('(', '', $str);
    $str = str_replace(')', '', $str);
    $str = str_replace('（', '', $str);
    $str = str_replace('）', '', $str);
    $str = str_replace('-', '', $str);
    $str = str_replace('_', '', $str);
    $str = str_replace('――', '', $str);
    $str = str_replace('+', '', $str);
    $str = str_replace('=', '', $str);
    $str = str_replace('|', '', $str);
    $str = str_replace('\\', '', $str);
    $str = str_replace('[', '', $str);
    $str = str_replace(']', '', $str);
    $str = str_replace('【', '', $str);
    $str = str_replace('】', '', $str);
    $str = str_replace('{', '', $str);
    $str = str_replace('}', '', $str);
    $str = str_replace(';', '', $str);
    $str = str_replace('；', '', $str);
    $str = str_replace(':', '', $str);
    $str = str_replace('：', '', $str);
    $str = str_replace('\'', '', $str);
    $str = str_replace('"', '', $str);
    $str = str_replace('“', '', $str);
    $str = str_replace('”', '', $str);
    $str = str_replace(',', '', $str);
    $str = str_replace('，', '', $str);
    $str = str_replace('<', '', $str);
    $str = str_replace('>', '', $str);
    $str = str_replace('《', '', $str);
    $str = str_replace('》', '', $str);
    $str = str_replace('.', '', $str);
    $str = str_replace('。', '', $str);
    $str = str_replace('/', '', $str);
    $str = str_replace('、', '', $str);
    $str = str_replace('?', '', $str);
    $str = str_replace('？', '', $str);
    return trim($str);
}

//输出HTML
function e($string){
	return htmlentities($string);
}

//调试函数
if (!function_exists('dump')) {
    function dump ($var, $label = 'Dump', $echo = TRUE)
    {
        // Store dump in variable
        ob_start();
        var_dump($var);
        $output = ob_get_clean();

        // Add formatting
        $output = preg_replace("/\]\=\>\n(\s+)/m", "] => ", $output);
        $output = '<pre style="position:relative;z-index:999;background: #FFFEEF; color: #000; border: 1px dotted #000; padding: 10px; margin: 10px; text-align: left;">' . $label . ' => ' . $output . '</pre>';

        // Output
        if ($echo == TRUE) {
            echo $output;
        }
        else {
            return $output;
        }
    }
}

//修正时区
date_default_timezone_set('PRC');

//返回当前时间
function nowTime($type=3){
	if($type==1){
		$ShowTime=date("m-d");
	}else if($type==2){
		$ShowTime=date("Y-m-d");
	}else if($type==3){
		$ShowTime=date("Y-m-d H:i:s");
	}else if($type==4){
		$ShowTime=date("Y-m-d-His");
	}else if($type==5){
		$ShowTime=date("YmdHis");
	}else if($type==6){
		$ShowTime=date("Ymd");
	}else if($type==7){
		$ShowTime=date("His");
	}
	return $ShowTime;
}

//判断是否是移动端，false为非移动端，否则就是，需更新完善
function isMobile() {
    if(isset($_SERVER['HTTP_X_WAP_PROFILE'])) {
        return true;
    }
    if(isset ($_SERVER['HTTP_VIA'])) {
        //找不到为flase,否则为true
        return stristr($_SERVER['HTTP_VIA'], "wap") ? true : false;
    }
    if(isset($_SERVER['HTTP_USER_AGENT'])) {
        //此数组有待完善
        $clientkeywords = array ('nokia','sony','ericsson','mot','samsung','htc','sgh','lg','sharp','sie-','philips','panasonic','alcatel','lenovo','iphone','ipod','blackberry','meizu','android','netfront','symbian','ucweb','windowsce','palm','operamini','operamobi','openwave','nexusone','cldc','midp','wap','mobile');
		$clientkeywords2 = array ('iPad');
        // 从HTTP_USER_AGENT中查找手机浏览器的关键字
		if(preg_match("/(" . implode('|', $clientkeywords2) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT']))) {
            return false;
        }
        if(preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT']))) {
            return true;
        }
    }
    //协议法，因为有可能不准确，放到最后判断
    if (isset ($_SERVER['HTTP_ACCEPT'])) {
        // 如果只支持wml并且不支持html那一定是移动设备
        // 如果支持wml和html但是wml在html之前则是移动设备
        if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html')))) {
            return true;
        }
    }
	return false;
}

/**
 *
 * 根据php的$_SERVER['HTTP_USER_AGENT'] 中各种浏览器访问时所包含各个浏览器特定的字符串来判断是属于PC还是移动端
 * @author           discuz3x
 * @lastmodify    2014-04-09
 * @return  BOOL
 */
function isMobile2() {
	global $_G;
	$mobile = array();
	//coolpad判断
	$coolpad_list = array('coolpad');
	//各个触控浏览器中$_SERVER['HTTP_USER_AGENT']所包含的字符串数组
	$touchbrowser_list =array('iphone', 'android', 'phone', 'mobile', 'wap', 'netfront', 'java', 'opera mobi', 'opera mini',
	'ucweb', 'windows ce', 'symbian', 'series', 'webos', 'sony', 'blackberry', 'dopod', 'nokia', 'samsung',
	'palmsource', 'xda', 'pieplus', 'meizu', 'midp', 'cldc', 'motorola', 'foma', 'docomo', 'up.browser',
	'up.link', 'blazer', 'helio', 'hosin', 'huawei', 'novarra', 'webos', 'techfaith', 'palmsource',
	'alcatel', 'amoi', 'ktouch', 'nexian', 'ericsson', 'philips', 'sagem', 'wellcom', 'bunjalloo', 'maui', 'smartphone',
	'iemobile', 'spice', 'bird', 'zte-', 'longcos', 'pantech', 'gionee', 'portalmmm', 'jig browser', 'hiptop',
	'benq', 'haier', '^lct', '320x320', '240x320', '176x220');
	//window手机浏览器数组【猜的】
	$mobilebrowser_list =array('windows phone');
	//wap浏览器中$_SERVER['HTTP_USER_AGENT']所包含的字符串数组
	$wmlbrowser_list = array('cect', 'compal', 'ctl', 'lg', 'nec', 'tcl', 'alcatel', 'ericsson', 'bird', 'daxian', 'dbtel', 'eastcom',
	'pantech', 'dopod', 'philips', 'haier', 'konka', 'kejian', 'lenovo', 'benq', 'mot', 'soutec', 'nokia', 'sagem', 'sgh',
	'sed', 'capitel', 'panasonic', 'sonyericsson', 'sharp', 'amoi', 'panda', 'zte');

	$pad_list = array('pad', 'gt-p1000', 'iPad');
	$useragent = strtolower($_SERVER['HTTP_USER_AGENT']);
	if( ($v = dstrpos($useragent, $coolpad_list, true)) ) {
		$_G['mobile'] = $v;
		return true;
	}
	if( dstrpos($useragent, $pad_list) ) {
		return 'pad';
	}
	if( ($v = dstrpos($useragent, $mobilebrowser_list, true)) ){
		$_G['mobile'] = $v;
		return true;
	}
	if( ($v = dstrpos($useragent, $touchbrowser_list, true)) ){
		$_G['mobile'] = $v;
		return true;
	}
	if( ($v = dstrpos($useragent, $wmlbrowser_list)) ) {
		$_G['mobile'] = $v;
		return true; //wml版
	}
	$brower = array('mozilla', 'chrome', 'safari', 'opera', 'm3gate', 'winwap', 'openwave', 'myop');
	if(dstrpos($useragent, $brower)) return false;
	$_G['mobile'] = 'unknown';
	//对于未知类型的浏览器，通过$_GET['mobile']参数来决定是否是手机浏览器
	if( isset($_G['mobiletpl'][$_GET['mobile']]) ){
		return true;
	} else {
		return false;
	}
}

/**
 * 判断$arr中元素字符串是否有出现在$string中
 * @param  $string     $_SERVER['HTTP_USER_AGENT']
 * @param  $arr          各中浏览器$_SERVER['HTTP_USER_AGENT']中必定会包含的字符串
 * @param  $returnvalue 返回浏览器名称还是返回布尔值，true为返回浏览器名称，false为返回布尔值【默认】
 * @author           discuz3x
 * @lastmodify    2014-04-09
 */
function dstrpos($string, $arr, $returnvalue = false) {
	if(empty($string)) return false;
	foreach((array)$arr as $v) {
		if(strpos($string, $v) !== false) {
			$return = $returnvalue ? $v : true;
			return $return;
		}
	}
	return false;
}

//字符超出使用省略号，用法 strLenOut(内容，长度，是否添加省略号，编码)
function strLenOut($string = '数据读取错误', $len = 20, $dot = false, $word = "暂无内容", $charset = 'utf-8'){
	//过滤首尾空格
	$string = trim($string);
	$sLen = strlen($string);
	//如果截取长度小于等于0，则返回空
    if( !is_numeric($len) or $len <= 0 ){
        return $word;
    }
    //判断使用什么编码，默认为utf-8
    if ( strtolower($charset) == "utf-8" ){
        $len_step = 3; //如果是utf-8编码，则中文字符长度为3
    }else{
        $len_step = 2; //如果是gb2312或big5编码，则中文字符长度为2
    }
	//初始化计数当前已截取的字符串个数，此值为字符串的个数值（非字节数）
    $len_i = 0;
	//初始化应该要截取的总字节数
    $substr_len = 0;
	//开始截取
    for( $i=0; $i < $sLen; $i++ ){
        if ( $len_i >= $len ) break; //总截取$len个字符串后，停止循环
        //判断，如果是中文字符串，则当前总字节数加上相应编码的中文字符长度
        if( ord(substr($string,$i,1)) > 0xa0 ){
            $i += $len_step - 1;
            $substr_len += $len_step;
        }else{ //否则，为英文字符，加1个字节
            $substr_len ++;
        }
    	$len_i ++;
    }

    $result_str = substr($string,0,$substr_len);
	//如果截取长度大于总字符串长度，则直接返回当前字符串
    if( $substr_len >= $sLen ){
        return $string;

    }
	//判断是否添加省略号
	if($dot == true){
		$string = $result_str."...";
	}else{
		$string = $result_str;
	}
	return $string;
}

//PHP 过滤HTML代码空格,回车换行符的函数
function deletehtml($string){
	$string = str_replace('&nbsp;',chr(32),$string);
	$string = str_replace('&ldquo;','"',$string);
	$string = str_replace('&rdquo;','"',$string);
	$string = trim($string);
	$string = strip_tags($string,"");
	$string = preg_replace("{\t}","",$string);
	$string = preg_replace("{\r\n}","",$string);
	$string = preg_replace("{\r}","",$string);
	$string = preg_replace("{\n}","",$string);
	$string = preg_replace("{ }","",$string);
	return $string;
}

//检查字符串是否为空，为空则输出指定字符串
function emptyStr($string,$str = '无'){
	if(deletehtml($string) == ""){
		return $str;
	}else{
		return $string;
	}
}

//输出子分类
function get_tree_child($data,$id){
	$tree = new Tree;
	$tree->tree($data);
	return $tree->get_child_for($id);
}

//输出子分类数组
function get_tree_childArray($data,$id){
	$tree = new Tree;
	$tree->tree($data);
	return $tree->get_child($id);
}

//对象转数组
function object_to_array($obj){
	$_arr = is_object($obj) ? get_object_vars($obj) : $obj;
	foreach ($_arr as $key => $val){
		$val = (is_array($val) || is_object($val)) ? object_to_array($val) : $val;
		$arr[$key] = $val;
	}
	return $arr;
}

//英数随机
function MakeStr($length,$str = "2" ){
	switch ($str){
		case "1":
			$str = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
			break;
		case "2":
			$str = "ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
			break;
		case "3":
			$str = "1234567890";
			break;
	}
	$possible = $str;
	$str = "";
	while(strlen($str) < $length)
	$str .= substr($possible, (rand() % strlen($possible)), 1);
	return $str;
}

//PHP手机检测
function phone_vd($str){
	if (!is_numeric($str)) {return false;}
	return preg_match('#^13[\d]{9}$|^14[5,7,9]{1}\d{8}$|^15[^4]{1}\d{8}$|^17[0,1,2,3,5,6,7,8]{1}\d{8}$|^18[\d]{9}$#', $str) ? true : false;
}

//PHP邮箱检测
function email_vd($str){
	return preg_match('/^[a-z0-9][a-z\.0-9-_]+@[a-z0-9_-]+(?:\.[a-z]{0,3}\.[a-z]{0,2}|\.[a-z]{0,3}|\.[a-z]{0,2})$/i',$str);
}

//PHP座机检测
function camera_vd($str){
	return preg_match("/^(0[0-9]{2,3}-)?([2-9][0-9]{6,7})+(-[0-9]{1,4})?$/",$str);
}

//邮编检测
function zip_vd($str){
    return preg_match("/^\d{6}$/",$str);
}

//时间差比较，在差值内返回true
function time_compare($time,$num){
	$n_time = strtotime(nowTime()) - strtotime($time);
	if($n_time < $num){
		return true;
	}else{
		return false;
	}
}

//判断是否是微信
function isWeixin(){
	$agent = strtolower($_SERVER['HTTP_USER_AGENT']);
	$is_weixin = strpos($agent, 'micromessenger') ? true : false ;
	if($is_weixin){
		return true;
	}else{
		return false;
	}
}

//查找分类名称
function findChannel($id,$arr){
	for ($i=0;$i<count($arr);$i++){
		if ($arr[$i]["id"]==$id){
			return 	$arr[$i]["name"];
		}
	}
}

//时间 转换
function time2Units ($time){
	$year   = floor($time / 60 / 60 / 24 / 365);
	$time  -= $year * 60 * 60 * 24 * 365;
	$month  = floor($time / 60 / 60 / 24 / 30);
	$time  -= $month * 60 * 60 * 24 * 30;
	$week   = floor($time / 60 / 60 / 24 / 7);
	$time  -= $week * 60 * 60 * 24 * 7;
	$day    = floor($time / 60 / 60 / 24);
	$time  -= $day * 60 * 60 * 24;
	$hour   = floor($time / 60 / 60);
	$time  -= $hour * 60 * 60;
	$minute = floor($time / 60);
	$time  -= $minute * 60;
	$second = $time;
	$elapse = '';
	$unitArr = array('年'  =>'year', '个月'=>'month',  '周'=>'week', '天'=>'day',
					 '小时'=>'hour', '分钟'=>'minute', '秒'=>'second'
					 );

	foreach ( $unitArr as $cn => $u )
	{
		if ( $$u > 0 )
		{
			$elapse = $$u . $cn;
			break;
		}
	}
	return $elapse;
 }

 
/***********************************************************************************************
*函数功能描述: 发送短信功能
*示例：

$result=sms_send("136xxxx6488","短信内容");
if($result===TRUE)	//发送成功
else //发送失败

*函数参数: numbers-接收手机号码(多个使用英文逗号分隔) 、content-短信内容(不包含签名) 、template- TRUE 模板通道(默认) / FALSE 非模板通道(尽量避免使用,可能存在延时)
*函数返回值: 返回TRUE表示成功，失败则返回失败原因
***********************************************************************************************/
function sms_send($numbers=NULL,$content=NULL,$template=TRUE){

	$CI =& get_instance();
	if($CI->config->item("key_id")=="" || $CI->config->item("key_secret")=="") return false;
	if($numbers==NULL || $content==NULL) return false;

	$host = "https://erp.brandsh.cn/api_sms_v3";
    $data = array(
    	"key_id"=>$CI->config->item("key_id"),
    	"key_secret"=>md5(md5($CI->config->item("key_secret")).time()),
    	"time"=>time(),
    	"numbers"=>$numbers,
    	"content"=>$content,
    	"template"=>$template?1:0
    );

    $result=json_decode(postData($host, $data));

    if($result->error) return $result;
    else return TRUE;
}


//POST数据
function postData($url, $data){
	$ch = curl_init();  
	$timeout = 10;   
	curl_setopt($ch, CURLOPT_URL, $url);  
	curl_setopt($ch, CURLOPT_POST, TRUE);  
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);  
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  
	curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
	$handles = curl_exec($ch);
	curl_close($ch);

	return $handles;
}


/***********************************************************************************************
*函数功能描述: 发送邮件功能
*示例：

$result=mail_send("xxx@brandsh.cn","邮件标题","邮件HTML内容");
if($result===TRUE)	//发送成功
else //发送失败

*函数参数: mailto-收件地址（一封邮件收件人列表如果是多人，地址可以提交以逗号分隔的列表或是一个数组） 、subject-邮件标题、content-短信内容(不包含签名) 、BCC-密送地址(一般用于正式环境保存邮件留档)
*函数返回值: 返回TRUE表示成功，FALSE失败（如需debug打开下方print_debugger行注释）
***********************************************************************************************/
function mail_send($mailto=NULL,$subject=NULL,$content=NULL,$BCC=NULL){
	$CI =& get_instance(); 
	
	$config_data=$CI->session->userdata("config");
	if($config_data["mail_smtp"]=="" || $config_data["mail_user"]=="" || $config_data["mail_password"]=="") return false;
	if($mailto==NULL || $subject==NULL || $content==NULL) return false;

	$CI->load->library('email');
	
	//配置邮箱SMTP
	$config=array(
		"protocol"=>"smtp",
		"smtp_host"=>$config_data["mail_smtp"],
		"smtp_user"=>$config_data["mail_user"],
		"smtp_pass"=>$config_data["mail_password"],
		"mailtype"=>"html",
		"newline"=>"\r\n",
		"crlf"=>"\r\n"
	);
	$CI->email->initialize($config);
	
	//邮件内容配置
	$CI->email->from($config_data["mail_user"], $config_data["mail_name"]);
	$CI->email->to($mailto); 
	$CI->email->subject($subject);
	$CI->email->message($content);
	if($BCC<>NULL) $CI->email->bcc($BCC);

	$result=$CI->email->send();
	//echo $CI->email->print_debugger();

	if($result) return TRUE;
	else return FALSE;
}
