<?php

namespace App\Models;

use App\Models\Links\HasLinksInterface;
use App\Models\Links\HasLinksTrait;
use App\Models\Observations\HasObservationsInterface;
use App\Models\Observations\HasObservationsTrait;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 *
 *
 * @property string $uuid
 * @property string $name
 * @property string $variety
 * @property string $botanical
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Plot> $plots
 * @property-read int|null $plots_count
 * @method static \Illuminate\Database\Eloquent\Builder|Plant newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Plant newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Plant query()
 * @method static \Illuminate\Database\Eloquent\Builder|Plant whereBotanical($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Plant whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Plant whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Plant whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Plant whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Plant whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Plant whereVariety($value)
 * @mixin \Eloquent
 */
class Plant extends Model implements HasObservationsInterface, HasLinksInterface
{
    use HasFactory;
	use HasUuids;
	use HasObservationsTrait;
	use HasLinksTrait;

	protected $primaryKey = 'uuid';

	protected $guarded = [];

	public function plots(): HasMany
	{
		return $this->hasMany(Plot::class);
	}
}
