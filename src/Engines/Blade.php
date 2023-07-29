<?php

declare(strict_types=1);

namespace Twent\Ssg\Engines;

use Illuminate\View\Compilers\BladeCompiler;
use Illuminate\View\Factory as BladeFactory;
use Illuminate\View\FileViewFinder;
use Illuminate\Container\Container;
use Illuminate\Events\Dispatcher;
use Illuminate\Filesystem\Filesystem;
use Illuminate\View\Engines\EngineResolver;
use Illuminate\View\Engines\CompilerEngine;

final class Blade
{
    public string $viewsDir;
    public string $cacheDir;

    private BladeFactory $blade;
    private object $data;

    public function __construct(
        ?string $basePath = null
    ) {
        $basePath = $basePath ?? dirname(__FILE__, 3);

        $this->viewsDir = $basePath . '/resources/views';
        $this->cacheDir = $basePath . '/cache';

        if (! is_dir($this->cacheDir)) {
            mkdir($this->cacheDir, 0755);
        }

        $viewFinder = new FileViewFinder(
            new Filesystem(),
            [$this->viewsDir]
        );

        $eventDispatcher = new Dispatcher(new Container());

        $engineResolver = new EngineResolver();

        $engineResolver->register(
            'blade',
            function () {
                return new CompilerEngine(
                    new BladeCompiler(
                        new Filesystem(),
                        $this->cacheDir
                    )
                );
            }
        );

        $this->blade = new BladeFactory(
            $engineResolver,
            $viewFinder,
            $eventDispatcher
        );
    }

    public function render(object $data): string
    {
        $this->data = $data;

        if (
            ! isset($this->data->view)
            || ! isset($this->data->path)
        ) {
            return '';
        }

        return $this->blade->make(
            $data->view,
            get_object_vars($data)
        )->render();
    }

    public function save(string $html): bool
    {
        if (isset($this->data->path)) {
            return File::store($html, $this->data->path);
        }

        return File::store($html, $this->data->path);
    }
}
