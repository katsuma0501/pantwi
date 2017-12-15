<?php
ini_set( 'display_errors', 1 );
ini_set('error_reporting', E_ALL);
mb_internal_encoding("UTF-8");

/**
* POSTでAPIをコール
*/
function get($url, $param=array()){
    try{
       $curl = curl_init($url);       
       curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
       curl_setopt($curl,CURLOPT_SSL_VERIFYPEER, FALSE);
       curl_setopt($curl,CURLOPT_SSL_VERIFYHOST, FALSE);
       curl_setopt($curl,CURLOPT_RETURNTRANSFER, TRUE);
       curl_setopt($curl,CURLOPT_FOLLOWLOCATION, TRUE);
       curl_setopt($curl,CURLOPT_POSTFIELDS, http_build_query($param));
       curl_setopt($curl,CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
       curl_setopt($curl,CURLINFO_HEADER_OUT,true);
       
       $result = curl_exec($curl);

       // ステータスコード取得
       $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);

    //    $res = json_decode($result, true);

       $errno = curl_errno($curl);
       $error = curl_error($curl);

       curl_close($curl);
       
       if (CURLE_OK !== $errno) {
           throw new RuntimeException($error, $errno);
       }else{
            // var_dump($code);
            // var_dump($res);
            return $result;
       }

   }catch (Exception $e){
       echo "API Error is :". $e->getMessage();
       return false;
   }
}

function h($str){
    return htmlspecialchars($str, ENT_QUOTES, 'utf-8');
}

$lat = h($_GET['lat']);
$lon = h($_GET['lon']);

$grunabi_api = "https://api.gnavi.co.jp/RestSearchAPI/20150630/?keyid=9543a647f939cabad7f1982c54167ea1&format=json&input_coordinates_mode=1&latitude=". $lat ."&longitude=". $lon ."&range=3&category_s=RSFST18007";

$ret = get($grunabi_api);

// return "success";
// echo json_encode($result);
echo $ret;