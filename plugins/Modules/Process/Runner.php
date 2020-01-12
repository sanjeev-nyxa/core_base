<?php

namespace Labs\Modules\Process;

use Labs\Modules\Contracts\RepositoryInterface;
use Labs\Modules\Contracts\RunableInterface;

class Runner implements RunableInterface
{
    /**
     * The module instance.
     * @var RepositoryInterface
     */
    protected $module;

    public function __construct(RepositoryInterface $module)
    {
        $this->module = $module;
    }

    /**
     * Run the given command.
     *
     * @param string $command
     */
    public function run($command)
    {
        passthru($command);
    }
}
