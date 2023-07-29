<?php

declare(strict_types=1);

namespace Twent\Ssg\Compilers;

use Symfony\Component\Finder\SplFileInfo;
use Twent\Ssg\Output\Console;
use Twent\Ssg\Engines\File;

abstract class Compiler
{
    public ?object $json;
    public ?SplFileInfo $file;

    public function checkContent(bool $showErrors = true): bool
    {
        $console = Console::init();

        if (! isset($this->json->view)) {
            if ($showErrors) {
                $console->error(
                    $this->file,
                    'the view attribute is missing'
                );
            }

            return false;
        }

        if (! isset($this->json->path)) {
            $path = str_replace(
                File::contentDir(false),
                '',
                $this->file
            );

            $this->json->path = pathinfo($path, PATHINFO_DIRNAME) . '/' . pathinfo($path, PATHINFO_FILENAME);
        }

        return true;
    }
}
