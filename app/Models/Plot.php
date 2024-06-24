<?php

namespace App\Models;

use App\Models\Observations\HasObservationsInterface;
use App\Models\Observations\HasObservationsTrait;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 *
 *
 * @property string $uuid
 * @property string $garden_uuid
 * @property string $plant_uuid
 * @property string $name
 * @property string|null $description
 * @property \Illuminate\Support\Carbon $planted_at
 * @property \Illuminate\Support\Carbon|null $germinated_at
 * @property \Illuminate\Support\Carbon|null $harvested_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \App\Models\Garden $garden
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Observation> $observations
 * @property-read int|null $observations_count
 * @property-read \App\Models\Plant $plant
 * @method static \Illuminate\Database\Eloquent\Builder|Plot newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Plot newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Plot query()
 * @method static \Illuminate\Database\Eloquent\Builder|Plot whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Plot whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Plot whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Plot whereGardenUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Plot whereGerminatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Plot whereHarvestedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Plot whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Plot wherePlantUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Plot wherePlantedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Plot whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Plot whereUuid($value)
 * @mixin \Eloquent
 */
class Plot extends Model implements HasObservationsInterface
{
    use HasFactory;
	use HasUuids;
	use HasObservationsTrait;

	protected $primaryKey = 'uuid';

	protected $guarded = [];

	protected $casts = [
		'planted_at' => 'datetime',
		'germinated_at' => 'datetime',
		'harvested_at' => 'datetime',
	];

	public function garden(): BelongsTo
	{
		return $this->belongsTo(Garden::class);
	}

	public function plants(): BelongsToMany
	{
		return $this->belongsToMany(Plant::class);
	}
}
