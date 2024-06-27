<?php

namespace App\Http\Packets\Photos;

use App\Http\Packets\ModelPacket;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/** @extends ModelPacket<Media> */
class PhotoPacket extends ModelPacket
{
	public function data(): array
	{
		return [
			'src' => $this->model->getUrl(),
			'thumb' => $this->model->getUrl('thumb'),
		];
	}
}
