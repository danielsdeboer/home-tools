<?php

namespace App\Http\Requests\Links;

use Illuminate\Foundation\Http\FormRequest;

class LinkRequest extends FormRequest
{
	public function rules(): array
	{
		return [
			'link' => ['required', 'string', 'url'],
			'description' => ['present', 'nullable', 'string'],
		];
	}
}
