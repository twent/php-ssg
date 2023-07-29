<?php

declare(strict_types=1);

namespace Twent\Ssg\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Twent\Ssg\Ssg;

final class Build extends Command
{
    protected static $defaultName = 'build';

    protected function configure()
    {
        $this->setDescription('Builds the site')
            ->setHelp(
                'This command compiles all of your content files into 
                static HTML and saves them in a directory tree under /dist'
            )
            ->addArgument(
                'page',
                InputArgument::OPTIONAL,
                'The path of a single page to be built instead of the whole site'
            );
    }

    protected function execute(
        InputInterface $input,
        OutputInterface $output
    ): int {
        $output->writeln([
            'Building',
            '=============',
        ]);

        $ssg = new Ssg(dirname(__FILE__, 3));

        $ssg->build($input->getArgument('page'));

        $output->writeln(['']);

        return Command::SUCCESS;
    }
}
