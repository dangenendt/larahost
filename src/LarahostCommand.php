<?php

namespace Ankitjain28may\Larahost;

use Laravel\Installer\Console\NewCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;

class LarahostCommand extends NewCommand
{
    /**
     * @var Process
     */
    private $process;
    /**
     * @var array
     */
    private $commands;

    public function __construct(Process $process, array $commands, string $name = null)
    {
        $this->process = $process;
        $this->commands = $commands;
        parent::__construct($name);
    }

    /**
     * Execute the command.
     *
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     * @return void
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        parent::execute($input, $output);
        $this->prepareProcess($input);
        $output->writeln('<info>Adding Nginx VirtualHost...</info>');
        $this->process->run(function ($type, $line) use ($output) {
            $output->write($line);
        });
    }

    /**
     * @param InputInterface $input
     */
    private function prepareProcess(InputInterface $input)
    {
        $directory = ($input->getArgument('name')) ? getcwd() . '/' . $input->getArgument('name') : getcwd();
        $name = $input->getArgument('name');
        array_push($this->commands, $name);
        $this->process->setWorkingDirectory($directory);
        $this->process->setCommandLine($this->commands);
        if ('\\' !== DIRECTORY_SEPARATOR && file_exists('/dev/tty') && is_readable('/dev/tty')) {
            $this->process->setTty(true);
        }
    }
}
