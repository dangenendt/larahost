<?php

use Ankitjain28may\Larahost\LarahostCommand;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;
use Tests\TestCase;

class LarahostCommandTest extends TestCase
{
    /** @var MockObject|InputInterface */
    private $inputInterfaceMock;

    /** @var MockObject|OutputInterface */
    private $outputInterfaceMock;

    /** @var MockObject|Process */
    private $processMock;

    /** @var array */
    private $commandsMock;

    /** @var LarahostCommand */
    private $instance;

    protected function setUp(): void
    {
        $this->inputInterfaceMock = $this->getMockBuilder(InputInterface::class)->disableOriginalConstructor()->getMock();
        $this->outputInterfaceMock = $this->getMockBuilder(OutputInterface::class)->disableOriginalConstructor()->getMock();
        $this->processMock = $this->getMockBuilder(Process::class)->disableOriginalConstructor()->getMock();
        $this->commandsMock = ['someFile.sh'];
        $this->instance = new LarahostCommand($this->processMock, $this->commandsMock, null);
    }

    protected function tearDown(): void
    {
        unset($this->instance);
        unset($this->processMock);
        unset($this->commandsMock);
        unset($this->inputInterfaceMock);
        unset($this->outputInterfaceMock);
        parent::tearDown();
    }

    public function testExecution()
    {
        $this->inputInterfaceMock->expects($this->any())->method('getArgument')->with('name')->willReturn('unit-test');
        $this->processMock->expects($this->once())->method('setWorkingDirectory')->willReturnSelf();
        $this->processMock->expects($this->once())->method('setCommandLine')->willReturnSelf();
        $this->processMock->expects($this->once())->method('run')->willReturnSelf();
        $this->outputInterfaceMock->expects($this->once())->method('writeln')->with('<info>Adding Nginx VirtualHost...</info>');
        $this->outputInterfaceMock->expects($this->once())->method('write');
        $this->instance->execute();
    }
}
