<?php

namespace App;

use Nette;


class Settings
{

	public static function getSettings()
	{
		$decoder = new Nette\Neon\Decoder();

		$config = [];

		$configFile = __DIR__ . '/../config/config.neon';
		if (file_exists($configFile)) {
			$config = $decoder->decode(file_get_contents($configFile));
		}

		$localFile = __DIR__ . '/../config/local.neon';
		if (file_exists($localFile)) {
			$local = $decoder->decode(file_get_contents($localFile));
			if ($local) {
				$config = array_merge_recursive($config, $local);
			}
		}

		return ['settings' => $config];
	}

}
