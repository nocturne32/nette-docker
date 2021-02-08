<?php

declare(strict_types=1);

namespace App;

use Nette\Bootstrap\Configurator;


class Bootstrap
{
	public static function boot(): Configurator
	{
		$configurator = new Configurator;
		$appDir = dirname(__DIR__);

        //$configurator->setDebugMode('secret@23.75.345.200'); // enable for your remote IP

		// NETTE_DEBUG je definován v docker-compose.yaml
        if (getenv('NETTE_DEBUG') === 'd87632de-5284-489e-aa61-38b9cd8d396f') {
            // na lokálu se automaticky debug mod zapne, ale v docker kontejneru se to aplikací nejeví jako localhost
            $configurator->setDebugMode(true);
        }

		$configurator->enableTracy($appDir . '/log');

		$configurator->setTimeZone('Europe/Prague');
		$configurator->setTempDirectory($appDir . '/temp');

		$configurator->createRobotLoader()
			->addDirectory(__DIR__)
			->register();

		$configurator->addConfig($appDir . '/config/common.neon');
		$configurator->addConfig($appDir . '/config/local.neon');

		return $configurator;
	}
}
