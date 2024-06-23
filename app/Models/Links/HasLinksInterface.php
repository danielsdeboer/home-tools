<?php

namespace App\Models\Links;

use App\Models\Link;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\MorphMany;

interface HasLinksInterface
{
	/** @return Collection<Link> */
	public function getLinks(): Collection;
	public function links(): MorphMany;
}
