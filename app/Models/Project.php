<?php

namespace App\Models;

use App\Models\Traits\ScopeTrait;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 *
 *
 * @property string $uuid
 * @property string $name
 * @property string $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Plant> $plants
 * @property-read int|null $plants_count
 * @method static \Database\Factories\ProjectFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Project newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Project newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Project query()
 * @method static \Illuminate\Database\Eloquent\Builder|Project scope(\App\Models\Scopes\ScopeInterface ...$scopes)
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereUuid($value)
 * @mixin \Eloquent
 */
class Project extends Model
{
    use HasFactory;
	use HasUuids;
	use ScopeTrait;

	protected $primaryKey = 'uuid';

	protected $guarded = [];

	public function plants(): BelongsToMany
	{
		return $this->belongsToMany(Plant::class);
	}
}
