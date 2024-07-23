<?php

namespace App\Http\Controllers\Gardening;

use Admin\Common\Settings\FrostDateSettings;
use App\Enums\ResourceIcon;
use App\Http\Packets\Page\BreadcrumbsPacket;
use App\Http\Packets\Page\CrumbPacket;
use App\Http\Packets\Page\HeaderPacket;
use App\Http\Packets\Page\HtmlTitlePacket;
use App\Http\Packets\Page\PagePacket;
use Carbon\CarbonImmutable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class SettingController
{
	private BreadcrumbsPacket $breadcrumbs;
	private HtmlTitlePacket $htmlTitle;

	public function __construct()
	{
		$this->breadcrumbs = new BreadcrumbsPacket(
			new CrumbPacket('Gardening', route('admin.farm.index')),
			new CrumbPacket('Settings', route('admin.farm.settings.index')),
		);

		$this->htmlTitle = new HtmlTitlePacket('Gardening', 'Settings');
	}

	public function index(FrostDateSettings $settings): Response
	{
		return Inertia::render('Gardening/Pages/Settings/SettingIndex', [
			'page' => new PagePacket(
				breadcrumbs: $this->breadcrumbs,
				header: new HeaderPacket('Settings', ResourceIcon::Setting),
				htmlTitle: $this->htmlTitle,
			),
			'settings' => [
				['name' => 'spring', 'value' => $settings->spring],
				['name' => 'autumn', 'value' => $settings->autumn],
			],
		]);
	}

	public function edit(FrostDateSettings $settings): Response
	{
		return Inertia::render('Gardening/Pages/Settings/SettingEdit', [
			'page' => new PagePacket(
				breadcrumbs: $this->breadcrumbs->pushDisabled(
					'Edit Settings',
				),
				header: new HeaderPacket(
					'Edit Settings',
					ResourceIcon::Setting,
				),
				htmlTitle: $this->htmlTitle->push('Edit Settings'),
			),
			'settings' => [
				'spring' => $settings->spring,
				'autumn' => $settings->autumn,
			],
		]);
	}

	public function update(
		Request $request,
		FrostDateSettings $settings,
	): RedirectResponse {
		$validated = $request->validate([
			'spring' => ['required', 'string', 'date'],
			'autumn' => ['required', 'string', 'date'],
		]);

		$settings->spring = CarbonImmutable::parse($validated['spring']);
		$settings->autumn = CarbonImmutable::parse($validated['autumn']);
		$settings->save();

		return redirect()->route('admin.farm.settings.index');
	}
}
