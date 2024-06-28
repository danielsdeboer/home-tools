<?php

namespace App\Http\Controllers\Gardening;

use App\Http\Requests\Photos\PhotoRequest;
use App\Models\Plant;
use Illuminate\Http\RedirectResponse;
use Spatie\Image\Exceptions\InvalidManipulation;
use Spatie\Image\Image;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class PlantPhotoController
{
	/**
	 * @throws FileIsTooBig
	 * @throws FileDoesNotExist
	 * @throws InvalidManipulation
	 */
	public function store(
		PhotoRequest $request,
		Plant $plant,
	): RedirectResponse {
		Image::load($request->file('photo'))
			->format(Manipulations::FORMAT_JPG)
			->fit(Manipulations::FIT_MAX, 1200, 1200)
			->save();

		$plant->addMedia($request->file('photo'))->toMediaCollection('photos');

		return redirect()->back();
	}

	public function destroy(Plant $plant, Media $photo): RedirectResponse {
		$photo->delete();

		return redirect()->back();
	}
}
