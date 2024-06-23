<?php

namespace App\Http\Requests\Observations;

use App\Models\Enums\ObservationStatus;
use App\Models\Observation;
use Illuminate\Foundation\Http\FormRequest;

class ObservationRequest extends FormRequest
{
	public function rules(): array
	{
		return [
			'content' => ['required', 'string'],
			'observed_at' => ['present', 'nullable', 'date'],
			'status' => ['present', 'nullable', 'string'],
		];
	}

	public function getValidatedForStore(): array
	{
		$validated = $this->validated();

		if ($this->input('observed_at') === null) {
			$validated['observed_at'] = now();
		}

		if ($this->input('status') === null) {
			$validated['status'] = ObservationStatus::Info;
		}

		return $validated;
	}

	public function getValidatedForUpdate(Observation $observation): array
	{
		$validated = $this->validated();

		if ($this->input('observed_at') === null) {
			$validated['observed_at'] = $observation->observed_at;
		}

		if ($this->input('status') === null) {
			$validated['status'] = $observation->status;
		}

		return $validated;
	}
}
