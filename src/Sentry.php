<?php declare(strict_types = 1);

namespace Prototype\Sentry;

use Nette\Security\User;
use Tracy\Logger;

class Sentry extends Logger
{

	public function register(string $dsn, string $environment): void
	{
		\Sentry\init([
			'dsn' => $dsn,
			'environment' => $environment,
		]);
	}

	public function setUser(User $user): void
	{
		if ( $user->isLoggedIn() ) {
			\Sentry\configureScope(function (\Sentry\State\Scope $scope) use ($user): void {
				$scope->setTag('user.id', (string) $user->getId());
			});
		}
	}

}
