<?php

namespace App\Http\Controllers\Bookmarks;

use App\Enums\ResourceIcon;
use App\Http\Packets\Bookmarks\BookmarkPacket;
use App\Http\Packets\Page\BreadcrumbsPacket;
use App\Http\Packets\Page\CrumbPacket;
use App\Http\Packets\Page\HeaderPacket;
use App\Http\Packets\Page\HtmlTitlePacket;
use App\Http\Packets\Page\PagePacket;
use App\Http\Packets\PaginationPacket;
use App\Models\Bookmark;
use DOMDocument;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rules\Unique;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class BookmarkController
{
	private BreadcrumbsPacket $breadcrumbs;
	private HtmlTitlePacket $htmlTitle;
	private ResourceIcon $icon;

	public function __construct()
	{
		$this->breadcrumbs = new BreadcrumbsPacket(
			new CrumbPacket('Bookmarks', route('bookmarks.index')),
		);

		$this->htmlTitle = new HtmlTitlePacket('Bookmarks');

		$this->icon = ResourceIcon::Bookmark;
	}

	public function index(): Response
	{
		return Inertia::render('Bookmarks/Pages/BookmarkIndex', [
			'page' => new PagePacket(
				createRoute: route('bookmarks.create'),
				breadcrumbs: $this->breadcrumbs,
				header: new HeaderPacket('Bookmarks', $this->icon),
				htmlTitle: $this->htmlTitle,
			),
			'bookmarks' => new PaginationPacket(
				Bookmark::latest()->paginate(perPage: 48),
				BookmarkPacket::class,
			),
		]);
	}

	public function create(): Response
	{
		return Inertia::render('Bookmarks/Pages/BookmarkCreate', [
			'page' => new PagePacket(
				breadcrumbs: $this->breadcrumbs->pushDisabled('Create'),
				header: new HeaderPacket(
					'Create a new bookmark',
					$this->icon,
				),
				htmlTitle: $this->htmlTitle->push('Create a new bookmark'),
			),
		]);
	}

	public function edit(Bookmark $bookmark): Response
	{
		return Inertia::render('Bookmarks/Pages/BookmarkEdit', [
			'page' => new PagePacket(
				breadcrumbs: $this->breadcrumbs->pushDisabled(
					sprintf('Edit: %s', $bookmark->name),
				),
				header: new HeaderPacket(
					sprintf('Edit Bookmark - %s', $bookmark->name),
					ResourceIcon::Bookmark,
				),
				htmlTitle: $this->htmlTitle->push(
					sprintf('Edit bookmark - %s', $bookmark->name),
				),
			),
			'bookmark' => new BookmarkPacket($bookmark),
		]);
	}

	public function store(Request $request): RedirectResponse
	{
		$bookmark = Bookmark::create($this->getValidated($request));

		return redirect()->route('bookmarks.index', $bookmark);
	}

	public function update(
		Request $request,
		Bookmark $bookmark,
	): RedirectResponse {
		$bookmark->update($this->getValidated($request, $bookmark));

		return redirect()->route('bookmarks.index', $bookmark);
	}

	protected function getValidated(
		Request $request,
		Bookmark|null $bookmark = null,
	): array {
		$unique = new Unique(Bookmark::class, 'url');

		$validated = $request->validate([
			'name' => ['present', 'nullable', 'string'],
			'url' => [
				'required',
				'url',
				$bookmark
					? $unique->ignore($bookmark)
					: $unique,
			],
		]);

		$urlFailure = fn (string|null $message = null) => throw ValidationException::withMessages([
			'url' => $message ?? 'Could not fetch the URL. Please provide a name manually.',
		]);

		if ($validated['name'] === null) {
			try {
				$response = Http::get($validated['url'])->throw();

				$dom = new DOMDocument();

				$loaded = @$dom->loadHTML($response->body());

				if (!$loaded) {
					$urlFailure();
				}

				$list = $dom->getElementsByTagName('title');

				if ($list->length === 0) {
					$urlFailure();
				}

				$validated['name'] = $list->item(0)->textContent;
			} catch (RequestException) {
				$urlFailure();
			}
		}

		return $validated;
	}
}
