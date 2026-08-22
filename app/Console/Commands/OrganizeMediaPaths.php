<?php

namespace App\Console\Commands;

use App\Support\Media\ModelSectionPathGenerator;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class OrganizeMediaPaths extends Command
{
    protected $signature = 'media:organize-paths
        {--dry-run : Show what would be moved without changing files}
        {--force : Replace an existing target file when necessary}';

    protected $description = 'Move legacy numeric Spatie media folders into model/collection based folders.';

    public function handle(ModelSectionPathGenerator $pathGenerator): int
    {
        $dryRun = (bool) $this->option('dry-run');
        $force = (bool) $this->option('force');
        $movedMedia = 0;
        $alreadyOrganized = 0;
        $missingMedia = 0;
        $movedFiles = 0;

        $this->components->info($dryRun
            ? 'Dry run: no files will be changed.'
            : 'Organizing media files...');

        Media::query()
            ->orderBy('id')
            ->chunkById(100, function ($mediaItems) use (
                $pathGenerator,
                $dryRun,
                $force,
                &$movedMedia,
                &$alreadyOrganized,
                &$missingMedia,
                &$movedFiles
            ): void {
                foreach ($mediaItems as $media) {
                    $legacyBase = $this->legacyBasePath($media);
                    $targetBase = rtrim($pathGenerator->getPath($media), '/');
                    $diskNames = array_values(array_unique(array_filter([
                        $media->disk,
                        $media->conversions_disk,
                    ])));

                    $foundAnySource = false;
                    $foundAnyTarget = false;
                    $mediaMoved = false;

                    foreach ($diskNames as $diskName) {
                        $disk = Storage::disk($diskName);
                        $sourceFiles = $disk->allFiles($legacyBase);
                        $targetFiles = $disk->allFiles($targetBase);

                        if ($targetFiles !== []) {
                            $foundAnyTarget = true;
                        }

                        if ($sourceFiles === []) {
                            continue;
                        }

                        $foundAnySource = true;

                        foreach ($sourceFiles as $sourceFile) {
                            $relative = ltrim(substr($sourceFile, strlen($legacyBase)), '/');
                            $targetFile = $targetBase.'/'.$relative;

                            if ($sourceFile === $targetFile) {
                                continue;
                            }

                            $this->line(sprintf(
                                '%s %s:%s -> %s',
                                $dryRun ? '[DRY]' : '[MOVE]',
                                $diskName,
                                $sourceFile,
                                $targetFile
                            ));

                            if ($dryRun) {
                                $movedFiles++;
                                $mediaMoved = true;
                                continue;
                            }

                            if ($disk->exists($targetFile)) {
                                if (! $force) {
                                    $this->warn("Target exists, skipped: {$targetFile}");
                                    continue;
                                }

                                $disk->delete($targetFile);
                            }

                            $targetDirectory = dirname($targetFile);

                            if ($targetDirectory !== '.') {
                                $disk->makeDirectory($targetDirectory);
                            }

                            if (! $disk->move($sourceFile, $targetFile)) {
                                $this->error("Could not move {$sourceFile}");
                                continue;
                            }

                            $movedFiles++;
                            $mediaMoved = true;
                        }

                        if (! $dryRun && $disk->allFiles($legacyBase) === []) {
                            $disk->deleteDirectory($legacyBase);
                        }
                    }

                    if ($mediaMoved) {
                        $movedMedia++;
                        continue;
                    }

                    if (! $foundAnySource && $foundAnyTarget) {
                        $alreadyOrganized++;
                        continue;
                    }

                    if (! $foundAnySource && ! $foundAnyTarget) {
                        $missingMedia++;
                        $this->warn("Missing files for media #{$media->id} ({$media->file_name})");
                    }
                }
            });

        $this->newLine();
        $this->table(
            ['Result', 'Count'],
            [
                ['Media moved', $movedMedia],
                ['Files moved', $movedFiles],
                ['Already organized', $alreadyOrganized],
                ['Missing media', $missingMedia],
            ]
        );

        if ($dryRun) {
            $this->components->warn('Dry run completed. Run without --dry-run to apply changes.');
        } elseif ($missingMedia === 0) {
            $this->components->info('Media organization completed successfully.');
        }

        return $missingMedia > 0 ? self::FAILURE : self::SUCCESS;
    }

    private function legacyBasePath(Media $media): string
    {
        $prefix = trim((string) config('media-library.prefix', ''), '/');

        return $prefix !== ''
            ? $prefix.'/'.$media->getKey()
            : (string) $media->getKey();
    }
}
