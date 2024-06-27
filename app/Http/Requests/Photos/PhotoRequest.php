<?php

namespace App\Http\Requests\Photos;

use Illuminate\Foundation\Http\FormRequest;

class PhotoRequest extends FormRequest
{
	public function rules(): array
	{
		return [
			'photo' => ['required', 'image',],
		];
	}
}
