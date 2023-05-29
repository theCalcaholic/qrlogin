<?php
declare(strict_types=1);
// SPDX-FileCopyrightText: Tobias Knöppler <tobias@knoeppler.net>
// SPDX-License-Identifier: AGPL-3.0-or-later

namespace OCA\QRLogin\AppInfo;

use OCA\QRLogin\QrLoginOption;
use OCP\AppFramework\App;
use OCP\AppFramework\Bootstrap\IBootContext;
use OCP\AppFramework\Bootstrap\IBootstrap;
use OCP\AppFramework\Bootstrap\IRegistrationContext;

class Application extends App implements IBootstrap {
	public const APP_ID = 'qrlogin';

	public function __construct() {
		parent::__construct(self::APP_ID);
	}

	public function register(IRegistrationContext $context): void {
		$context->registerAlternativeLogin(QrLoginOption::class);
	}

	public function boot(IBootContext $context): void
	{
	}
}
