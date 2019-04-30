<?php

use Illuminate\Database\Capsule\Manager as Capsule;


if (!defined('MONITISCHECK_FUNCTIONS'))
{
	
define('MONITISCHECK_FUNCTIONS', true);

function monitischeck_settings($key=null, $reload=false)
{
	static $_settings = null;
	try
	{
		if ($reload || empty($_settings))
		{
			if (empty($key))
			{
				$keys = [];
				foreach (Capsule::table('tbladdonmodules')
					->where('module', 'monitischeck')
					->get() as $setting)
				{
					$keys[$setting->setting] = $setting->value;
				}

				$_settings = $keys;
				return $keys;
			}
			else
			{
				return Capsule::table('tbladdonmodules')
					->where([
					['module', 'monitischeck'],
					['setting', $key],
					])->pluck('value');
			}
		}
		else
		{
			if (empty($key))
			{
				return $_settings;
			}
			else
			{
				return $_settings[$key];
			}
		}
	}
	catch (\Exception $e)
	{
		return null;
	}
}


}