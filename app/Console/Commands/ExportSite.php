<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ExportSite extends Command
{
    protected $signature = 'site:export {--url= : Public site URL (https://example.com), used for share-preview links}';

    protected $description = 'Render the home page to static files in /dist (for Vercel or any static host)';

    public function handle(): int
    {
        $root = 'http://static-export.invalid';
        config(['app.url' => $root]);
        url()->forceRootUrl($root);

        $response = app()->handle(Request::create($root . '/'));
        if ($response->getStatusCode() !== 200) {
            $this->error('Render failed: HTTP ' . $response->getStatusCode());
            return self::FAILURE;
        }

        // Absolute links become relative, or use the real site URL when given.
        // Also handles the JSON-escaped form (http:\/\/host\/path) used inside inline scripts.
        $site = rtrim((string) $this->option('url'), '/');
        $escRoot = str_replace('/', '\/', $root);
        $content = $response->getContent();
        $html = $site !== ''
            ? str_replace([$root, $escRoot], [$site, str_replace('/', '\/', $site)], $content)
            : str_replace([$root . '/', $root, $escRoot . '\/', $escRoot], ['/', '/', '\/', '\/'], $content);

        $dist = base_path('dist');
        File::deleteDirectory($dist);
        File::makeDirectory($dist, 0755, true);
        File::put($dist . '/index.html', $html);

        if (File::isDirectory(public_path('images'))) {
            File::copyDirectory(public_path('images'), $dist . '/images');
        }
        foreach (['favicon.ico', 'robots.txt'] as $file) {
            if (File::exists(public_path($file))) {
                File::copy(public_path($file), $dist . '/' . $file);
            }
        }

        $this->info('Exported to dist/ (' . round(strlen($html) / 1024, 1) . ' KB index.html)');
        return self::SUCCESS;
    }
}
