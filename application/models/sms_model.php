<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class sms_model extends CI_Model {
  
  private $tableName = 'sales';
  
    function __construct() 
    {
    /* Call the Model constructor */
    parent::__construct();
    }
    function send_sms($phonenumber,$msg)
    {
        
        //$phonenumber = substr($phonenumber, -9);
        $phonenumber = $this->format_phone($phonenumber);
        $url         = 'https://digitalreachapi.dialog.lk/refresh_token.php';
        $username    = "sakura_apid";
        $password    = "sakura@89999d";
        $data        = array(
            "u_name" => $username,
            "passwd" => $password
        );
        $data_json   = json_encode($data);
        $ch          = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json'
        ));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        $access_token = preg_replace("/[^0-9]/", "", $response);
        $url          = 'https://digitalreachapi.dialog.lk/camp_req.php';
        date_default_timezone_set('Asia/Colombo');
        $s_time    = date("Y-m-d h:i:s");
        $e_time    = date('Y-m-d h:i:s', strtotime("+1 days", strtotime(date("Y-m-d h:i:s"))));
        $data      = array(
            "msisdn" => "" . $phonenumber . "",
            "channel" => "1",
            "mt_port" => "MANKI",
            "s_time" => $s_time,
            "e_time" => $e_time,
            "msg" => "" . $msg . "",
           // "callback_url" => "https://digitalreachapi.dialog.lk//call_back.php"
        );
        $data_json = json_encode($data);
        $ch        = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Authorization:' . $access_token . ''
        ));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }
    function format_phone($phone){
        $rv = "";
        $filtered_phone_number = filter_var($phone, FILTER_SANITIZE_NUMBER_INT);
        $phone_to_check = str_replace("-", "", $filtered_phone_number);
        $phone_to_check = intval($phone_to_check);
        if(strlen($phone_to_check) < 9 || strlen($phone_to_check) > 12){
            $rv = "";
        }else{
            $rv = substr($phone_to_check, -9);
        }
        return "94".$rv;
    }
    //$otp         = (rand(1000, 9999));
}