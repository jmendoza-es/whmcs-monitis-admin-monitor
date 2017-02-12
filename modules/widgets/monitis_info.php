<?php
/**
 * WHMCS Monitis Check Addon Module
 *
 * @copyright Copyright (c) Lapsum (Opera Servicom S.L.) 2017
 * @license www.lapsum.com
 */
 
use WHMCS\Input\Sanitize;

require_once '../modules/addons/monitischeck/functions.php';

if (!defined("WHMCS"))
    die("This file cannot be accessed directly");

if(!empty(monitischeck_settings())) {
	
function widget_monitis_info($vars) {
    global $whmcs,$_ADMINLANG;

    $title = "MONITIS Admin monitoring";
	$jquerycode ="
	(function monitis_update() {
	  $.get('../monitis.php?'+Math.floor((Math.random() * 10000) + 1), function(data) {
		$('#monitis').html(data);
		setTimeout(monitis_update, 5000);
	  });
	})();";

	$content = '<div id="monitis"><div style="height:100px; line-height:100px; text-align:center;">Loading data...</div></div><div class="widget-footer" style="clear: both;margin-top: 0px;float: left;width: 103%;">
<a href="http://dashboard.monitis.com/" target="_blank" class="btn btn-default btn-sm">Monitis.com</a>
</div>';

    return array('title' => $title, 'content' => $content, 'jquerycode' => $jquerycode);

}

add_hook("AdminHomeWidgets",1,"widget_monitis_info");

}
 
