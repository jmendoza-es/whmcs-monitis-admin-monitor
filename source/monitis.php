<?php
/**
 * WHMCS Monitis Check Addon Module
 *
 * @copyright Copyright (c) Lapsum (Opera Servicom S.L.) 2017
 * @license www.lapsum.com
 */
 
require 'init.php';
require_once 'modules/addons/monitischeck/functions.php';

	$settings = monitischeck_settings();
	$monitis_apiKey = $settings['apiKey'];		
    $monitis_secretKey = $settings['secretKey'];
	
	$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => 'http://api.monitis.com/api?action=authToken&apikey='.$monitis_apiKey.'&secretkey='.$monitis_secretKey.'&output=json'
));

	$result = curl_exec($curl);
	$resultJson = json_decode($result);
	$authToken = $resultJson->authToken;
	
	$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => 'http://api.monitis.com/api?apikey='.$monitis_apiKey.'&output=json&version=2&action=testsLastValues'
));

	$result = curl_exec($curl);
	$resultJson = json_decode($result);
	$servers = $resultJson[1]->data;
	$buffer = "";
	
	function check_perf($val) {
		if($val <= 100) { return '#690'; }
		if($val > 100) { return 'red; font-size:12px !important'; }
	}
	
	if(!empty($servers)) {
		
	for($i = 0; $i<count($servers); $i++) {
		if($servers[$i]->status == "OK") {
		$buffer .= '<div style="border:1px solid #eaeaea; width:100px; float:left; position:relative; margin-right:5px; margin-bottom:5px; background:#fff; height:85px; ">';
		$buffer .= '<span style="position:absolute; text-transform:uppercase; text-align:center; font-size:10px; font-weight:bold; left:0;right:0; top:1px;">'.$servers[$i]->groups[0].'</span>';
		$buffer .= '<span style="position:absolute; text-transform:uppercase; text-align:center; font-size:8px; font-weight:bold; left:0;right:0; bottom:1px;">'.$servers[$i]->name.'</span>';
		$buffer .= '<span style="border:5px solid '.check_perf($servers[$i]->perf).'; border-radius:100px; text-align:center; font-size:15px; line-height:29px; margin-left:30px; margin-top:20px; color:#333; font-weight:bold; height:40px; width:40px; display:block;">'.$servers[$i]->perf.'</span>';
		$buffer .= '</div>';
		} else {
		$buffer .= '<div style="border:1px solid #eaeaea; width:100px; float:left; position:relative; margin-right:5px; margin-bottom:5px; background:red; height:85px; ">';
		$buffer .= '<span style="position:absolute; text-transform:uppercase; text-align:center; font-size:10px; font-weight:bold; color:#fff; left:0;right:0; top:1px;">'.$servers[$i]->groups[0].'</span>';
		$buffer .= '<span style="position:absolute; text-transform:uppercase; text-align:center; font-size:8px; font-weight:bold; color:#fff; left:0;right:0; bottom:1px;">'.$servers[$i]->name.'</span>';
		$buffer .= '<span style="border:5px solid #fff; border-radius:100px; text-align:center; font-size:15px; line-height:29px; margin-left:30px; margin-top:20px; color:#fff; font-weight:bold; height:40px; width:40px; display:block;">'.$servers[$i]->perf.'</span>';
		$buffer .= '</div>';
		}
	}
	
	} else { $buffer .= '<p align="center"> No active monitors in your account or API credential misconfiguration. </p>'; }

echo $buffer;
	