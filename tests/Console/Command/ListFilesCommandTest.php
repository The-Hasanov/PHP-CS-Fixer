<?php

/*
 * This file is part of PHP CS Fixer.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *     Dariusz Rumiński <dariusz.ruminski@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace PhpCsFixer\Tests\Console\Command;

use PhpCsFixer\Console\Application;
use PhpCsFixer\Console\Command\ListFilesCommand;
use PhpCsFixer\Tests\TestCase;
use PhpCsFixer\ToolInfo;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * @internal
 *
 * @covers \PhpCsFixer\Console\Command\ListFilesCommand
 */
final class ListFilesCommandTest extends TestCase
{
    public function testListWithConfig()
    {
        $commandTester = $this->doTestExecute([
            '--config' => __DIR__ . '/../../Fixtures/ListFilesTest/.php-cs-fixer.php'
        ]);

        $expectedPath = './tests/Fixtures/ListFilesTest/needs-fixing/needs-fixing.php';
        // make the test also work on windows
        $expectedPath = str_replace('/', DIRECTORY_SEPARATOR, $expectedPath);

        $this->assertSame(escapeshellarg($expectedPath).PHP_EOL, $commandTester->getDisplay());
    }

    /**
     * @return CommandTester
     */
    private function doTestExecute(array $arguments)
    {
        $application = new Application();
        $application->add(new ListFilesCommand(new ToolInfo()));

        $command = $application->find('list-files');
        $commandTester = new CommandTester($command);

        $commandTester->execute($arguments);

        return $commandTester;
    }
}
