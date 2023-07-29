<?php

declare(strict_types=1);

namespace Twent\Ssg\Output;

use Symfony\Component\Finder\SplFileInfo;

final class Console
{
    public int $builds = 0;
    public int $errors = 0;

    private static ?self $instance = null;

    private function __construct()
    {
    }

    public static function init(): self
    {
        if (self::$instance == null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function getBuilds(): int
    {
        return $this->builds;
    }

    public function getErrors(): int
    {
        return $this->errors;
    }

    public function build(string $file, string $path): void
    {
        $this->builds++;

        echo basename($file) . ' rendered to ' . $path;
    }

    public function error(string $file, string $error): void
    {
        $this->errors++;

        echo basename($file) . ' could not be rendered because ' . $error;
    }

    public function end(array $buildTime): void
    {
        $fullBuildTime = round((($buildTime['end'] - $buildTime['start']) * 1000), 2);

        $buildPages = $this->builds === 1 ? 'page' : 'pages';
        $errorPages = $this->errors === 1 ? 'page' : 'pages';

        echo "\n";

        if ($this->builds) {
            echo $this->builds . ' ' . $buildPages . ' built in ' . $fullBuildTime . 'ms';
        }

        if ($this->errors) {
            echo $this->errors . ' ' . $errorPages . ' could not be built, see errors above';
        }
    }
}
