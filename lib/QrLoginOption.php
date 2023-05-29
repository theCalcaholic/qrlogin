<?php
declare(strict_types=1);

namespace OCA\QRLogin;

use OCA\QRLogin\AppInfo\Application;
use OCP\Authentication\IAlternativeLogin;
use OCP\IL10N;
use OCP\IURLGenerator;

class QrLoginOption implements IAlternativeLogin {

	protected IUrlGenerator $url;
	protected IL10N $l;

	public function __construct(IURLGenerator $url, IL10N $l) {
		$this->url = $url;
		$this->l = $l;
	}

	public function getLabel(): string
	{
		return $this->l->t("Scan QR Code");
	}

	public function getLink(): string
	{
		return $this->url->linkToRoute(Application::APP_ID.".login.showQr");
	}

	public function getClass(): string
	{
		return "qrlogin";
	}

	public function load(): void
	{ }
}
?>
