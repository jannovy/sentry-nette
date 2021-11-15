<?php declare(strict_types = 1);

namespace Prototype\Sentry;

use Nette\DI\CompilerExtension;
use Nette\PhpGenerator\ClassType;
use Tracy\Debugger;
use Tracy\ILogger;

class SentryExtension extends CompilerExtension
{

	/** @var bool */
	private $enabled = false;

	public function loadConfiguration(): void
	{
		if (!$this->config['dsn']) {
			Debugger::log('Unable to initialize SentryExtension, dsn config option is missing', ILogger::WARNING);
			return;
		}

		$this->enabled = true;

		$this->getContainerBuilder()
			->addDefinition($this->prefix('logger'))
			->setFactory(Sentry::class)
			->addSetup('register', [$this->config['dsn'], $this->config['environment']]);
	}

	public function beforeCompile(): void
	{
		if (!$this->enabled) {
			return;
		}

		$builder = $this->getContainerBuilder();
		if ($builder->hasDefinition('tracy.logger')) {
			$builder->getDefinition('tracy.logger')->setAutowired(false);
		}

		if ($builder->hasDefinition('security.user')) {
			$builder->getDefinition($this->prefix('logger'))
				->addSetup('setUser', [$builder->getDefinition('security.user')]);
		}
	}

	public function afterCompile(ClassType $class): void
	{
		if (!$this->enabled) {
			return;
		}

		$class->getMethod('initialize')
			->addBody('Tracy\Debugger::setLogger($this->getService(?));', [ $this->prefix('logger') ]);
	}

}
