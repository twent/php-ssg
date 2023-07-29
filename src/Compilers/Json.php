<?php

declare(strict_types=1);

namespace Twent\Ssg\Compilers;

use Twent\Ssg\Engines\File;
use Symfony\Component\Finder\SplFileInfo;

final class Json extends Compiler
{
    public function __construct(
        SplFileInfo $file
    ) {
        $this->file = $file;

        $this->json = json_decode(
            $file->getContents()
        );

        foreach ($this->json as $idx => $item) {
            if (
                is_string($item)
                && substr($item, 0, 5) === '/data'
                && substr($item, -5, 5) === '.json'
                && file_exists(File::$resourceDir . $item)
            ) {
                $this->json->{$idx} = json_decode(
                    file_get_contents(File::$resourceDir . $item)
                );
            }
        }

        $this->json->vite = File::viteManifestData();
    }
}
