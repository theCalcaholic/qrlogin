<?php
declare(strict_types=1);
// SPDX-FileCopyrightText: Tobias Knöppler <tobias@knoeppler.net>
// SPDX-License-Identifier: AGPL-3.0-or-later

namespace OCA\QRLogin\Db;

use DateTime;
use DateTimeInterface;
use JsonSerializable;

use OCP\AppFramework\Db\Entity;

/**
 * @method getId(): int
 * @method getExpires(): DateTime
 * @method setExpires(DateTime $expires): void
 * @method getUserId(): string
 * @method setUserId(string $userId): void
 * @method getClientId(): string
 * @method setClientId(string $userId): void
 */
class Grant extends Entity implements JsonSerializable {
	protected string $userId = '';
	protected string $clientId = '';
	protected DateTime $expires;

	public function jsonSerialize(): array {
		return [
			'id' => $this->id,
			'userId' => $this->userId,
			'expires' => $this->expires->format(DateTimeInterface::ATOM)
		];
	}
}
