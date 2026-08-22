<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class MediaStorageDoctor extends Command
{
    protected $signature = 'media:storage-doctor {--limit=20 : Maximum missing media rows to display}';

    protected $description = 'Check public media root, URL configuration and database media file availability.';

    public function handle(): int
    {
        $root = (string) config('filesystems.disks.public.root');
        $url = (string) config('filesystems.disks.public.url');
        $limit = max(1, (int) $this->option('limit'));

        if ($root === '') {
            $this->error('Public disk root is not configured.');

            return self::FAILURE;
        }

        File::ensureDirectoryExists($root, 0755, true);

        $missing = [];
        $totalMedia = Media::query()->count();

        Media::query()
            ->orderBy('id')
            ->chunkById(100, function ($mediaItems) use (&$missing, $limit): void {
                foreach ($mediaItems as $media) {
                    if (count($missing) >= $limit) {
                        return;
                    }

                    $path = $media->getPathRelativeToRoot();

                    if (! Storage::disk($media->disk)->exists($path)) {
                        $missing[] = [
                            'id' => $media->id,
                            'collection' => $media->collection_name,
                            'file' => $media->file_name,
                            'expected' => $path,
                        ];
                    }
                }
            });

        $this->table(
            ['Check', 'Value'],
            [
                ['Public root', $root],
                ['Public URL', $url],
                ['Root exists', is_dir($root) ? 'YES' : 'NO'],
                ['Root writable', is_writable($root) ? 'YES' : 'NO'],
                ['Media records', $totalMedia],
                ['Missing files shown', count($missing)],
            ]
        );

        if ($missing !== []) {
            $this->newLine();
            $this->error('Some media files are missing from their expected organized paths.');
            $this->table(['ID', 'Collection', 'File', 'Expected path'], array_map(
                fn (array $row): array => [$row['id'], $row['collection'], $row['file'], $row['expected']],
                $missing
            ));
            $this->line('Run: php artisan media:organize-paths --dry-run');
            $this->line('Then: php artisan media:organize-paths');

            return self::FAILURE;
        }

        if (! is_writable($root)) {
            $this->error('Public media root is not writable.');

            return self::FAILURE;
        }

        $this->components->info('Single public media root is ready.');

        return self::SUCCESS;
    }
}
