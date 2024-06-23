<?php

namespace App\Http\Packets;

use Illuminate\Support\Collection;
use JsonSerializable;

interface KeyablePacketInterface extends JsonSerializable
{
	public function getKey(): string;
	public function setKey(string $key): void;
	public function setKeyed(bool $keyed): void;
	public function defaultKey(): string;
	public function keyableData(): mixed;
	public function getData(): array|Collection;
}
