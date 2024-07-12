<?php

namespace App\Http\Controllers\Shopping;

use App\Enums\ResourceIcon;
use App\Http\Packets\Page\BreadcrumbsPacket;
use App\Http\Packets\Page\CrumbPacket;
use App\Http\Packets\Page\HeaderPacket;
use App\Http\Packets\Page\HtmlTitlePacket;
use App\Http\Packets\Page\PagePacket;
use App\Http\Packets\PaginationPacket;
use App\Http\Packets\Shopping\ShoppingItems\ShoppingItemPacket;
use App\Models\ShoppingItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Unique;
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
		return Inertia::render('Shopping/Pages/ShoppingItems/ShoppingItemIndex', [
			'page' => new PagePacket(
				createRoute: route('shopping.items.create'),
				breadcrumbs: $this->breadcrumbs,
				header: new HeaderPacket('Items', ResourceIcon::ShoppingItem),
				htmlTitle: $this->htmlTitle,
			),
			'items' => new PaginationPacket(
				ShoppingItem::orderBy('name')->paginate(perPage: 24),
				ShoppingItemPacket::class,
			),
		]);
	}

	public function show(ShoppingItem $item): Response
	{
		return Inertia::render('Shopping/Pages/ShoppingItems/ShoppingItemShow', [
			'page' => new PagePacket(
				editRoute: route('shopping.items.edit', $item),
				breadcrumbs: $this->breadcrumbs->pushDisabled($item->name),
				header: new HeaderPacket(
					$item->name,
					ResourceIcon::ShoppingItem,
				),
				htmlTitle: $this->htmlTitle->push($item->name),
			),
			'item' => new ShoppingItemPacket($item),
		]);
	}

	public function create(): Response
	{
		return Inertia::render('Shopping/Pages/ShoppingItems/ShoppingItemCreate', [
			'page' => new PagePacket(
				breadcrumbs: $this->breadcrumbs->pushDisabled('Create'),
				header: new HeaderPacket(
					'Create a new item',
					ResourceIcon::ShoppingItem,
				),
				htmlTitle: $this->htmlTitle->push('Create a new item'),
			),
		]);
	}

	public function edit(ShoppingItem $item): Response
	{
		return Inertia::render('Shopping/Pages/ShoppingItems/ShoppingItemEdit', [
			'page' => new PagePacket(
				breadcrumbs: $this->breadcrumbs->pushDisabled(
					sprintf('Edit: %s', $item->name),
				),
				header: new HeaderPacket(
					sprintf('Edit ShoppingItem - %s', $item->name),
					ResourceIcon::ShoppingItem,
				),
				htmlTitle: $this->htmlTitle->push(
					sprintf('Edit item - %s', $item->name),
				),
			),
			'item' => new ShoppingItemPacket($item),
		]);
	}

	public function store(Request $request): RedirectResponse
	{
		$validated = $request->validate([
			'name' => [
				'required',
				'string',
				new Unique(ShoppingItem::class, 'name'),
			],
		]);

		$item = ShoppingItem::create($validated);

		return redirect()->route('shopping.items.show', $item);
	}

	public function update(Request $request, ShoppingItem $item): RedirectResponse
	{
		$validated = $request->validate([
			'name' => [
				'required',
				'string',
				(new Unique(ShoppingItem::class, 'name'))->ignore($item)
			],
		]);

		$item->update($validated);

		return redirect()->route('shopping.items.show', $item);
	}
}
