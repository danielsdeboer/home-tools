<?php

namespace App\Models\Links;

use App\Models\Link;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * @mixin Model
 * @mixin HasLinksInterface
 * @implements HasLinksInterface
 */
trait HasLinksTrait
{
	public function getLinks(): Collection
	{
		return $this->links;
	}

	public function links(): MorphMany
	{
		return $this->morphMany(
			related: Link::class,
			name: 'linkable',
			id: 'linkable_uuid',
		);
	}
}
