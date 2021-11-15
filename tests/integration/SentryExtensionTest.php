<?php declare(strict_types = 1);

namespace Prototype\Sentry\Test;

use App\Bootstrap;
use Doctrine\ORM\EntityManager;
use Prototype\Sentry\Sentry;
use Nette\DI\Container;
use PHPUnit\Framework\TestCase;

class SentryExtensionTest extends TestCase
{

	/** @var Container */
	public static $container;

	public static function setUpBeforeClass(): void
	{
		// Get and store DI container
		self::$container = Bootstrap::bootForTests()->createContainer();
	}

	public function testExtensionIsPresentInContainer(): void
	{
		$this->assertInstanceOf(Sentry::class, self::$container->getByType(Sentry::class));
	}

}
