<?php
declare(strict_types=1);
// SPDX-FileCopyrightText: Tobias Knöppler <tobias@knoeppler.net>
// SPDX-License-Identifier: AGPL-3.0-or-later

namespace OCA\QRLogin\Controller;

use OCA\QRLogin\AppInfo\Application;
use OCA\QRLogin\Service\QrLoginService;use OCP\AppFramework\ApiController;
use OCP\AppFramework\Http;
use OCP\AppFramework\Http\DataResponse;
use OCP\AppFramework\Http\JSONResponse;
use OCP\IRequest;
use OCP\ISession;
use OCP\IUser;
use OCP\IUserManager;
use OCP\IUserSession;

class QrApiController extends ApiController {
	private QrLoginService $service;
	private ISession $session;
	private IUserManager $userManager;
	private IUserSession $userSession;
	private ?string $userId;

	use Errors;

	public function __construct(IRequest $request,
								QrLoginService $service,
								ISession $session,
								IUserSession $userSession,
								IUserManager $userManager,
								?string $userId)
	{
		parent::__construct(Application::APP_ID, $request);
		$this->service = $service;
		$this->userManager = $userManager;
		$this->userId = $userId;
		$this->session = $session;
		$this->userSession = $userSession;
	}

	/**
	 * @CORS
	 * @UseSession
	 * @PublicPage
	 * @param string $clientUuid
	 * @return JSONResponse
	 */
	public function requestLogin(string $clientUuid): JSONResponse {
		$grant = $this->service->getLoginGrant($clientUuid);
		if ($grant === null) {
			return new JSONResponse(['message' => 'Login not granted'], Http::STATUS_FORBIDDEN);
		}
		$uid = $grant->getUserId();
		$this->userManager->search($uid);
		$user = $this->userManager->get($uid);
		$this->userSession->setUser($user);
		$this->userSession->completeLogin($user, ['loginName' => $user->getUID(), 'password' => '']);
		$this->userSession->createSessionToken($this->request, $user->getUID(), $user->getUID());
		$this->userSession->createRememberMeToken($user);
	}

}
?>
