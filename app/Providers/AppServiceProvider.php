<?php

namespace App\Providers;

use App\Models\FooterLink;
use App\Models\FooterSetting;
use App\Models\HeaderMenuItem;
use App\Models\HeaderSetting;
use App\Models\MetaPixelScript;
use App\Models\Product;
use App\Models\SiteSetting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::composer('frontend.layouts.master', function ($view): void {
            $siteSetting = SiteSetting::current()->loadMissing('media');
            $headerSetting = HeaderSetting::current();
            $footerSetting = FooterSetting::current();

            $headerMenuItems = HeaderMenuItem::query()
                ->where('status', true)
                ->orderBy('sort_order')
                ->orderBy('id')
                ->get(['id', 'label', 'route_name', 'custom_url', 'open_new_tab']);

            $footerLinks = FooterLink::query()
                ->where('status', true)
                ->orderBy('sort_order')
                ->orderBy('id')
                ->get(['id', 'section_key', 'label', 'route_name', 'custom_url', 'open_new_tab'])
                ->groupBy('section_key');

            $footerProducts = Product::query()
                ->where('status', true)
                ->whereHas('category', function ($query) {
                    $query->where('status', true);
                })
                ->orderByDesc('is_featured')
                ->orderBy('sort_order')
                ->orderBy('id')
                ->limit(8)
                ->get(['id', 'name', 'slug']);

            $trackingScripts = config('tracking.enabled')
                ? MetaPixelScript::query()
                    ->where('status', true)
                    ->orderBy('placement')
                    ->orderBy('sort_order')
                    ->orderBy('id')
                    ->get(['id', 'placement', 'script_code'])
                    ->groupBy('placement')
                : collect();

            $view->with(compact(
                'siteSetting',
                'headerSetting',
                'footerSetting',
                'headerMenuItems',
                'footerLinks',
                'footerProducts',
                'trackingScripts'
            ));
        });
    }
}
