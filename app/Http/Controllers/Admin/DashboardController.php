<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\ContactMessage;
use App\Models\HomeSectionPhoto;
use App\Models\MetaPixelScript;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $stats = [
            'products' => Product::query()->count(),
            'active_products' => Product::query()->where('status', true)->count(),
            'featured_products' => Product::query()->where('status', true)->where('is_featured', true)->count(),
            'categories' => Category::query()->count(),
            'active_categories' => Category::query()->where('status', true)->count(),
            'reviews' => Review::query()->count(),
            'active_reviews' => Review::query()->where('status', true)->count(),
            'average_rating' => round((float) (Review::query()->where('status', true)->avg('rating') ?? 0), 1),
            'contact_messages' => ContactMessage::query()->count(),
            'new_messages' => ContactMessage::query()->where('status', 'new')->count(),
            'home_photos' => HomeSectionPhoto::query()->count(),
            'active_home_photos' => HomeSectionPhoto::query()->where('status', true)->count(),
            'active_pixels' => MetaPixelScript::query()->where('status', true)->count(),
            'media_files' => Media::query()->count(),
            'media_bytes' => (int) Media::query()->sum('size'),
        ];

        $recentProducts = Product::query()
            ->with('category:id,name')
            ->latest('id')
            ->limit(5)
            ->get(['id', 'category_id', 'name', 'slug', 'status', 'created_at']);

        $recentMessages = ContactMessage::query()
            ->latest('id')
            ->limit(5)
            ->get(['id', 'name', 'email', 'phone', 'subject', 'status', 'created_at']);

        return view('admin.dashboard', [
            'title' => 'Dashboard',
            'breadcrumb' => [
                ['text' => 'Dashboard', 'url' => route('admin.dashboard')],
            ],
            'stats' => $stats,
            'recentProducts' => $recentProducts,
            'recentMessages' => $recentMessages,
            'mediaUsage' => $this->formatBytes($stats['media_bytes']),
            'publicMediaUrl' => (string) config('filesystems.disks.public.url'),
        ]);
    }

    private function formatBytes(int $bytes): string
    {
        if ($bytes <= 0) {
            return '0 B';
        }

        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $power = min((int) floor(log($bytes, 1024)), count($units) - 1);
        $value = $bytes / (1024 ** $power);

        return number_format($value, $power === 0 ? 0 : 1).' '.$units[$power];
    }
}
