<?php

namespace App\Http\Packets\Gardening\Projects;

use App\Http\Packets\ModelPacket;
use App\Models\Project;

/** @extends ModelPacket<Project> */
class ProjectPacket extends ModelPacket
{
	public function pluckedData(): array
	{
		return [
			'uuid',
			'name',
			'description',
		];
	}
}
