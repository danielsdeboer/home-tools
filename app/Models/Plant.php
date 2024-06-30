<?php

namespace App\Models;

use App\Models\Links\HasLinksInterface;
use App\Models\Links\HasLinksTrait;
use App\Models\Observations\HasObservationsInterface;
use App\Models\Observations\HasObservationsTrait;
use App\Models\Scopes\Gardening\Plots\PlotActiveScope;
use App\Models\Traits\ScopeTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Image\Enums\Fit;

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
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Link> $links
 * @property-read int|null $links_count
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, Media> $media
 * @property-read int|null $media_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Observation> $observations
 * @property-read int|null $observations_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Plot> $plots
 * @property-read int|null $plots_count
 * @method static \Database\Factories\PlantFactory factory($count = null, $state = [])
 * @method static Builder|Plant newModelQuery()
 * @method static Builder|Plant newQuery()
 * @method static Builder|Plant query()
 * @method static Builder|Plant scope(\App\Models\Scopes\ScopeInterface ...$scopes)
 * @method static Builder|Plant whereBotanical($value)
 * @method static Builder|Plant whereCreatedAt($value)
 * @method static Builder|Plant whereDeletedAt($value)
 * @method static Builder|Plant whereName($value)
 * @method static Builder|Plant whereUpdatedAt($value)
 * @method static Builder|Plant whereUuid($value)
 * @method static Builder|Plant whereVariety($value)
 * @mixin \Eloquent
 */
class Plant extends Model implements HasObservationsInterface, HasLinksInterface, HasMedia
{
    use HasFactory;
	use HasUuids;
	use HasObservationsTrait;
	use HasLinksTrait;
	use InteractsWithMedia;
	use ScopeTrait;

	protected $primaryKey = 'uuid';

	protected $guarded = [];

	public function registerMediaCollections(): void
	{
		$this->addMediaCollection('photos')
			->registerMediaConversions(function (Media $media = null) {
				$this
					->addMediaConversion('thumb')
					->fit(Manipulations::FIT_CROP, 300, 300)
					->nonQueued();
			});
	}

	public function plots(): BelongsToMany
	{
		return $this->belongsToMany(Plot::class);
	}

	public function activePlots(): BelongsToMany
	{
		return $this->plots()->scope(new PlotActiveScope());
	}
}
