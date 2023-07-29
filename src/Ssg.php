<?php

declare(strict_types=1);

namespace Twent\Ssg;

use Twent\Ssg\Compilers\Json;
use Twent\Ssg\Engines\Blade;
use Twent\Ssg\Engines\Content;
use Twent\Ssg\Engines\File;
use Twent\Ssg\Output\Console;

final class Ssg
{
    private array $buildTime;
    private string $basePath;

    public function __construct(
        ?string $basePath = null
    ) {
        $this->buildTime['start'] = microtime(true);
        $this->buildTime['end'] = 0;

        $this->basePath = $basePath ?? dirname(__FILE__, 2);
    }

    public function build(
        ?string $pageBuildOverride = null
    ): void {
        $blade = new Blade($this->basePath);

        $fileEngine = new File($this->basePath);
        $fileEngine->cleanOutputDir();

        $console = Console::init();

        foreach ($fileEngine->getContentFiles($pageBuildOverride) as $contentFile) {
            $compiler = null;
            $ext = $contentFile->getExtension();

            switch ($ext) {
                case 'json':
                    $compiler = new Json($contentFile);
                    break;
                default:
                    $console->error($contentFile, 'needs to be a json');
                    break;
            }

            if ($compiler && $compiler->checkContent()) {
                $compiler->json->cleaver = Content::generateCollection(
                    $fileEngine,
                    $pageBuildOverride
                );

                if ($blade->save($blade->render($compiler->json))) {
                    $console->build(
                        $compiler->file->getFilename(),
                        $compiler->json->path
                    );

                    continue;
                }

                $console->error($compiler->file->getFilename(), 'there was a problem saving');
            }
        }

        $this->buildTime['end'] = microtime(true);

        $console->end($this->buildTime);
    }
}
