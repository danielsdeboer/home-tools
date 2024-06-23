<?php

namespace App\Enums;

use JsonSerializable;

enum ResourceIcon: string implements JsonSerializable
{
	case Garden = 'garden';
	case Plot = 'plot';
	case Plant = 'plant';

	public function jsonSerialize(): string
	{
		return $this->value;
	}
}
