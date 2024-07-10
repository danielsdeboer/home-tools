<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 *
 *
 * @property string $uuid
 * @property string $name
 * @property string $location
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Observation> $observations
 * @property-read int|null $observations_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Plot> $plots
 * @property-read int|null $plots_count
 * @method static \Database\Factories\GardenFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Garden newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Garden newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Garden query()
 * @method static \Illuminate\Database\Eloquent\Builder|Garden whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Garden whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Garden whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Garden whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Garden whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Garden whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Garden whereUuid($value)
 * @mixin \Eloquent
 */
class ShoppingItem extends Model
{
    use HasFactory;
	use HasUuids;
	use SoftDeletes;

	protected $primaryKey = 'uuid';

	protected $guarded = [];
}
