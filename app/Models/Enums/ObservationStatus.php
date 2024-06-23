<?php

namespace App\Models\Enums;

enum ObservationStatus: string
{
	case Info = 'info';
	case Warning = 'warning';
	case Error = 'error';
	case Success = 'success';
	case None = 'none';
}
