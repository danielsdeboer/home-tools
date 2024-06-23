<?php

namespace App\Models;

use App\Models\Enums\ObservationStatus;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 *
 *
 * @property string $uuid
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $content
 * @property \Illuminate\Support\Carbon $observed_at
 * @property ObservationStatus $status
 * @property string $observable_uuid
 * @property string $observable_type
 * @property string|null $deleted_at
 * @property-read Model|\Eloquent $observable
 * @method static \Illuminate\Database\Eloquent\Builder|Observation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Observation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Observation query()
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
class Link extends Model
{
    use HasFactory;
	use HasUuids;

	protected $primaryKey = 'uuid';

	protected $guarded = [];

	public function linkable(): MorphTo
	{
		return $this->morphTo();
	}

}
