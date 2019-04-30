<?php
/**
 * WHMCS Monitis Check Addon Module
 *
 * @copyright Copyright (c) Lapsum (Opera Servicom S.L.) 2017
 * @license www.lapsum.com
 */

if (!defined('WHMCS')) {
    die('This file cannot be accessed directly');
}

use Illuminate\Database\Capsule\Manager as Capsule;

require_once __DIR__ . '/functions.php';

function monitischeck_config()
{
	$templates = array();
	foreach (Capsule::table('tblemailtemplates')
		->where('type', 'product')
		->get() as $template)
	{
		$templates[] = $template->name;
	}
	$admins = array();
	foreach (Capsule::table('tbladmins')
		->where('disabled', 0)
		->get() as $adminuser)
	{
		$admins[] = "{$adminuser->firstname} {$adminuser->lastname} ({$adminuser->username})";
	}
	$configarray = array(
		'name' => 'Monitis Admin monitor',
		'description' => 'This module shows a small widget in the admin dashboard containing all monitors you have configured in your Monitis account to let your admin users to quickly see the overall server status.',
		'version' => '1.00',
		'author' => '<a href="https://www.lapsum.com/"><img src="https://static.lapsum.com/img/lapsum-logo-whmcs-module.png" width="138" height="50" alt="Lapsum"></a>',
		'fields' => array(
			'apiKey' => array(
				'FriendlyName' => 'API key',
				'Type' => 'text',
				'Size' => '25',
				'Description' => 'Enter your Monitis API key.',
			),
			'secretKey' => array(
				'FriendlyName' => 'Secret key',
				'Type' => 'password',
				'Size' => '25',
				'Description' => 'Enter your Monitis Secret API key.',
			)
		));
	return $configarray;
}

 



