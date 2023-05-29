<?php
declare(strict_types=1);

namespace OCA\QRLogin\Controller;

use OCA\QRLogin\AppInfo\Application;
use OCP\AppFramework\Controller;
use OCP\AppFramework\Http\TemplateResponse;
use OCP\IConfig;
use OCP\IRequest;
use OCP\Util;

class LoginController extends Controller {
	private IConfig $config;

	public function __construct($appName, IRequest $request, IConfig $config)
	{
		$this->config = $config;
		parent::__construct($appName, $request);
	}


	/**
	 * @return bool
	 */
	private function isSecure(): bool {
		// no restriction in debug mode
		return $this->config->getSystemValueBool('debug', false) || $this->request->getServerProtocol() === 'https';
	}

	/**
	 * @NoCSRFRequired
	 * @PublicPage
	 */
	public function showQr(): TemplateResponse {
		if (!$this->isSecure()) {
			$response = new TemplateResponse('qrlogin', 'error', [
				'error' => 'Connection to nextcloud is not secure. QR Login not available.'
			], TemplateResponse::RENDER_AS_ERROR);
			$response->setStatus(500);
			return $response;
		}
		Util::addScript(Application::APP_ID, 'qrlogin-main');
		return new TemplateResponse('qrlogin', 'login/showqr', [], TemplateResponse::RENDER_AS_PUBLIC);
	}
}
?>
