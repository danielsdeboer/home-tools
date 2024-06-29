<?php

namespace App\Models;

use App\Models\Enums\ObservationStatus;
use App\Models\Traits\ScopeTrait;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * 
 *
 * @property string $uuid
 * @property string $content
 * @property \Illuminate\Support\Carbon $observed_at
 * @property ObservationStatus $status
 * @property string $observable_uuid
 * @property string $observable_type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read Model|\Eloquent $observable
 * @method static \Database\Factories\ObservationFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Observation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Observation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Observation query()
 * @method static \Illuminate\Database\Eloquent\Builder|Observation scope(\App\Models\Scopes\ScopeInterface ...$scopes)
 * @method static \Illuminate\Database\Eloquent\Builder|Observation whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Observation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Observation whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Observation whereObservableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Observation whereObservableUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Observation whereObservedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Observation whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Observation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Observation whereUuid($value)
 * @mixin \Eloquent
 */
class Observation extends Model
{
    use HasFactory;
	use HasUuids;
	use ScopeTrait;

	protected $primaryKey = 'uuid';

	protected $guarded = [];

	protected $casts = [
		'observed_at' => 'datetime',
		'status' => ObservationStatus::class,
	];

	public function observable(): MorphTo
	{
		return $this->morphTo(
			name: 'observable',
			type: 'observable_type',
			id: 'observable_uuid',
			ownerKey: 'uuid',
		);
	}
}
