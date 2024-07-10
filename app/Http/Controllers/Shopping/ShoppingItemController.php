<?php

namespace App\Http\Controllers\Shopping;

use App\Enums\ResourceIcon;
use App\Http\Packets\CollectionPacket;
use App\Http\Packets\Shopping\Items\GardenPacket;
use App\Http\Packets\Shopping\Items\GardenPlantPacket;
use App\Http\Packets\Shopping\Items\ItemsShowPacket;
use App\Http\Packets\Page\BreadcrumbsPacket;
use App\Http\Packets\Page\CrumbPacket;
use App\Http\Packets\Page\HeaderPacket;
use App\Http\Packets\Page\HtmlTitlePacket;
use App\Http\Packets\Page\PagePacket;
use App\Http\Packets\PaginationPacket;
use App\Http\Packets\Shopping\ShoppingItems\ShoppingItemPacket;
use App\Models\Garden;
use App\Models\Plant;
use App\Models\ShoppingItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ShoppingItemController
{
	private BreadcrumbsPacket $breadcrumbs;
	private HtmlTitlePacket $htmlTitle;

	public function __construct()
	{
		$this->breadcrumbs = new BreadcrumbsPacket(
			new CrumbPacket('Shopping', route('shopping.index')),
			new CrumbPacket('Items', route('shopping.items.index')),
		);

		$this->htmlTitle = new HtmlTitlePacket('Items', 'Shopping');
	}

	public function index(): Response
	{
		return Inertia::render('Shopping/Pages/Items/ItemsIndex', [
			'page' => new PagePacket(
				createRoute: route('shopping.items.create'),
				breadcrumbs: $this->breadcrumbs,
				header: new HeaderPacket('Items', ResourceIcon::Garden),
				htmlTitle: $this->htmlTitle,
			),
			'items' => new PaginationPacket(
				ShoppingItem::orderBy('name')->paginate(perPage: 24),
				ShoppingItemPacket::class,
			),
		]);
	}

	public function show(Garden $garden): Response
	{
		return Inertia::render('Shopping/Pages/Items/ItemsShow', [
			'page' => new PagePacket(
				editRoute: route('shopping.items.edit', $garden),
				breadcrumbs: $this->breadcrumbs->push(
					new CrumbPacket($garden->name, '', disabled: true),
				),
				header: new HeaderPacket($garden->name, ResourceIcon::Garden),
				htmlTitle: $this->htmlTitle->push($garden->name),
			),
			'garden' => new ItemsShowPacket($garden),
			'plants' => new CollectionPacket(
				Plant::orderBy('name')->get(),
				GardenPlantPacket::class,
			),
		]);
	}

	public function create(): Response
	{
		return Inertia::render('Shopping/Pages/Items/ItemsCreate', [
			'page' => new PagePacket(
				breadcrumbs: $this->breadcrumbs->pushDisabled('Create'),
				header: new HeaderPacket(
					'Create a new garden',
					ResourceIcon::Garden,
				),
				htmlTitle: $this->htmlTitle->push('Create a new garden'),
			),
		]);
	}

	public function edit(Garden $garden): Response
	{
		return Inertia::render('Shopping/Pages/Items/ItemsEdit', [
			'garden' => new ItemsShowPacket($garden),
			'page' => new PagePacket(
				breadcrumbs: $this->breadcrumbs->pushDisabled(
					sprintf('Edit: %s', $garden->name),
				),
				header: new HeaderPacket(
					sprintf('Edit Garden - %s', $garden->name),
					ResourceIcon::Garden,
				),
				htmlTitle: $this->htmlTitle->push(
					sprintf('Edit garden - %s', $garden->name),
				),
			),
		]);
	}

	public function store(Request $request): RedirectResponse
	{
		$validated = $request->validate([
			'name' => ['required', 'string'],
			'location' => ['required', 'string'],
			'description' => ['present', 'nullable', 'string'],
		]);

		$garden = Garden::create($validated);

		return redirect()->route('shopping.items.show', $garden);
	}

	public function update(Request $request, Garden $garden): RedirectResponse
	{
		$validated = $request->validate([
			'name' => ['required', 'string'],
			'location' => ['required', 'string'],
			'description' => ['present', 'nullable', 'string'],
		]);

		$garden->update($validated);

		return redirect()->route('shopping.items.show', $garden);
	}
}
