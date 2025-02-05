<?php

namespace App\Http\Controllers\Gardening;

use App\Enums\ResourceIcon;
use App\Http\Packets\Gardening\GardeningObservationPacket;
use App\Http\Packets\Page\BreadcrumbsPacket;
use App\Http\Packets\Page\CrumbPacket;
use App\Http\Packets\Page\HeaderPacket;
use App\Http\Packets\Page\HtmlTitlePacket;
use App\Http\Packets\Page\PagePacket;
use App\Http\Packets\PaginationPacket;
use App\Models\Observation;
use App\Models\Scopes\Gardening\GardeningObservableScope;
use Inertia\Inertia;
use Inertia\Response;

class ObservationController
{
	private BreadcrumbsPacket $breadcrumbs;

	public function __construct()
	{
		$this->breadcrumbs = new BreadcrumbsPacket(
			new CrumbPacket('Gardening', route('admin.farm.index')),
			new CrumbPacket(
				'Observations',
				route('admin.farm.observations.index'),
			),
		);

		$this->htmlTitle = new HtmlTitlePacket('Gardening', 'Observations');
	}

	public function index(): Response
	{
		$observations = Observation::query()
			->with('observable')
			->scope(new GardeningObservableScope())
			->orderBy('observed_at', 'desc')
			->paginate(perPage: 24);

		return Inertia::render(
			'Gardening/Pages/Observations/ObservationsIndex',
			[
				'page' => new PagePacket(
					breadcrumbs: $this->breadcrumbs,
					header: new HeaderPacket(
						'Observations', ResourceIcon::Observation,
					),
					htmlTitle: $this->htmlTitle,
				),
				'observations' => new PaginationPacket(
					$observations,
					GardeningObservationPacket::class,
				),
			],
		);
	}
}
