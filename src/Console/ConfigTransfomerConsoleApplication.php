<?php

declare (strict_types=1);
namespace ConfigTransformer202106194\Symplify\ConfigTransformer\Console;

use ConfigTransformer202106194\Symfony\Component\Console\Application;
use ConfigTransformer202106194\Symfony\Component\Console\Command\Command;
use ConfigTransformer202106194\Symplify\PackageBuilder\Console\Command\CommandNaming;
final class ConfigTransfomerConsoleApplication extends \ConfigTransformer202106194\Symfony\Component\Console\Application
{
    /**
     * @param Command[] $commands
     */
    public function __construct(\ConfigTransformer202106194\Symplify\PackageBuilder\Console\Command\CommandNaming $commandNaming, array $commands)
    {
        foreach ($commands as $command) {
            $commandName = $commandNaming->resolveFromCommand($command);
            $command->setName($commandName);
            $this->add($command);
        }
        parent::__construct('Config Transformer');
    }
}
