<?php
declare(strict_types=1);

namespace OCA\QRLogin\Service;

use DateTime;
use OCA\QRLogin\Db\Grant;
use function _HumbugBoxaf422ad7431f\Amp\Promise\rethrow;

class QrLoginService {
	public function getLoginGrant(string $clientUuid): Grant {
		$g = new Grant();
		$g->setUserId("user");
		$g->setClientId("");
		$g->setExpires(new DateTime());
		return $g;
	}
}

?>
