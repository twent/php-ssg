<?php

declare(strict_types=1);

namespace Twent\Ssg\Engines;

use Symfony\Component\Finder\Finder;
use Symfony\Component\Filesystem\Filesystem;

final class File
{
    private static string $basePath;
    public static string $resourceDir;
    public static string $contentDir;
    public static string $outputDir;
    public static string $viteManifest;

    public function __construct(
        ?string $basePath = null
    ) {
        self::$basePath = ! empty($basePath)
            ? $basePath
            : dirname(__FILE__, 3);

        self::$resourceDir = self::$basePath . '/resources';
        self::$contentDir = self::$basePath . '/resources/pages';
        self::$outputDir = self::$basePath . '/dist';
        self::$viteManifest = self::$basePath . '/dist/manifest.json';
    }

    public static function basePath(
        bool $includeTrailingSlash = true
    ): string {
        return $includeTrailingSlash
            ? self::$basePath . '/'
            : self::$basePath;
    }

    public static function contentDir(
        bool $includeTrailingSlash = true
    ): string {
        return $includeTrailingSlash
            ? self::$contentDir . '/'
            : self::$contentDir;
    }

    public static function outputDir(
        bool $includeTrailingSlash = true
    ): string {
        return $includeTrailingSlash
            ? self::$outputDir . '/'
            : self::$outputDir;
    }

    public static function viteManifest(): string
    {
        return self::$viteManifest;
    }

    public static function cleanOutputDir(
        bool $ignoreDotFiles = true,
        array $exclude = ['assets', 'manifest.json']
    ): void {
        if (! is_dir(self::$outputDir)) {
            return;
        }

        $finder = new Finder();
        $filesystem = new Filesystem();

        $filesToRemove = $finder
            ->files()
            ->in(self::$outputDir)
            ->ignoreDotFiles($ignoreDotFiles)
            ->exclude($exclude)
            ->notName('manifest.json');

        $filesystem->remove($filesToRemove);

        $directoriesToRemove = $finder
            ->directories()
            ->in(self::$outputDir)
            ->ignoreDotFiles($ignoreDotFiles)
            ->exclude($exclude);

        $filesystem->remove($directoriesToRemove);
    }

    public function getContentFiles(
        ?string $pageBuildOverride = null
    ): Finder {
        $finder = new Finder();

        return $finder
            ->files()
            ->in(self::$contentDir)
            //->path($pageBuildOverride)
            ->ignoreDotFiles(true)
            ->name(['*.json'])
            ->sortByModifiedTime();
    }

    public static function viteManifestData(): array
    {
        return json_decode(
            str_replace('/dist', '', file_get_contents(self::$viteManifest)),
            true
        );
    }

    public static function store(
        string $html,
        string $path
    ): bool {
        $outputDir = self::$outputDir . $path;

        if (!is_dir($outputDir)) {
            mkdir($outputDir, 0755, true);
        }

        $outputPath = $outputDir . '/index.html';

        return boolval(file_put_contents($outputPath, $html));
    }
}
