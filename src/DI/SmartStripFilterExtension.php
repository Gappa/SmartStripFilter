<?php

namespace Nelson\Latte\Filters\SmartStripFilter\DI;

use Nelson\Latte\Filters\SmartStripFilter\SmartStripFilter;
use Nette\DI\CompilerExtension;
use Nette\DI\Definitions\FactoryDefinition;

final class SmartStripFilterExtension extends CompilerExtension
{

	public function loadConfiguration()
	{
		$builder = $this->getContainerBuilder();
		$builder->addDefinition($this->prefix('default'))
			->setClass(SmartStripFilter::class);
	}


	public function beforeCompile()
	{
		$builder = $this->getContainerBuilder();

		// Latte filter
		$latteFactoryName = 'latte.latteFactory';
		if ($builder->hasDefinition($latteFactoryName)) {
			/** @var FactoryDefinition $latteFactory */
			$latteFactory = $builder->getDefinition($latteFactoryName);
			$latteFactory
				->getResultDefinition()
				->addSetup('addFilter', ['smartstrip', [$this->prefix('@default'), 'stripFilterAware']]);
		}
	}

}
