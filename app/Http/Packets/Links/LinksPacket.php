<?php

namespace App\Http\Packets\Links;

use App\Http\Packets\CollectionPacket;
use App\Http\Packets\KeyablePacketInterface;
use App\Http\Packets\KeyablePacketTrait;
use App\Models\Links\HasLinksInterface;
use Illuminate\Support\Collection;

class LinksPacket extends CollectionPacket implements KeyablePacketInterface
{
	use KeyablePacketTrait;

	public function __construct(HasLinksInterface $model)
	{
		parent::__construct($model->getLinks(), LinkPacket::class);
	}

	public function defaultKey(): string
	{
		return 'links';
	}

	public function keyableData(): Collection
	{
		return parent::jsonSerialize();
	}

	public function jsonSerialize(): array|Collection
	{
		return $this->getData();
	}
}
