<?php

declare(strict_types=1);

namespace Twent\Ssg\Engines;

use Twent\Ssg\Compilers\Json;
use Illuminate\Support\Collection;

final class Content
{
    public static function generateCollection(
        File $fileEngine,
        ?string $pageBuildOverride = null
    ): Collection {
        $content = [];
        $files = $fileEngine->getContentFiles($pageBuildOverride);

        foreach ($files as $contentFile) {
            $compiler = null;
            $ext = pathinfo($contentFile->getFilename(), PATHINFO_EXTENSION);

            switch ($ext) {
                case 'json':
                    $compiler = new Json($contentFile);
                    break;
                default:
                    break;
            }

            if ($compiler && $compiler->checkContent(false)) {
                $content[] = $compiler->json;
            }
        }

        return new Collection($content);
    }
}
