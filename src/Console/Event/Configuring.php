<?php

/*
 * This file is part of Flarum.
 *
 * For detailed copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */

namespace Flarum\Console\Event;

use Flarum\Foundation\Application;
use Illuminate\Console\Command;
use Symfony\Component\Console\Application as ConsoleApplication;
use Symfony\Component\EventDispatcher\EventDispatcher;

/**
 * Configure the console application.
 *
 * This event is fired after the core commands are added to the application.
 */
class Configuring
{
    /**
     * @var Application
     */
    public $app;

    /**
     * @var ConsoleApplication
     */
    public $console;
    /**
     * @var EventDispatcher
     */
    public $eventDispatcher;

    /**
     * @param Application        $app
     * @param ConsoleApplication $console
     * @param EventDispatcher    $eventDispatcher
     */
    public function __construct(Application $app, ConsoleApplication $console, EventDispatcher $eventDispatcher)
    {
        $this->app = $app;
        $this->console = $console;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * Add a console command to the flarum binary.
     *
     * @param Command|string $command
     */
    public function addCommand($command)
    {
        if (is_string($command)) {
            $command = $this->app->make($command);
        }

        if ($command instanceof Command) {
            $command->setLaravel($this->app);
        }

        $this->console->add($command);
    }
}
