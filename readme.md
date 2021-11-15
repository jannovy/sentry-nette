Sentry extension for Nette framework
=================

Instalation
------------

Install extension with composer

	composer require jannovy/sentry-nette

Configuration
------------

Register extension in common.neon file and setup DSN and environment

	extensions:
		sentry: Prototype\Sentry\SentryExtension

	sentry:
		dsn: {your sentry DSN}
		environment: localhost

