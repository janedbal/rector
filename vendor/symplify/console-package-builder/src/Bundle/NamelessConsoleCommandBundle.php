<?php

declare (strict_types=1);
namespace RectorPrefix20210729\Symplify\ConsolePackageBuilder\Bundle;

use RectorPrefix20210729\Symfony\Component\DependencyInjection\ContainerBuilder;
use RectorPrefix20210729\Symfony\Component\HttpKernel\Bundle\Bundle;
use RectorPrefix20210729\Symplify\ConsolePackageBuilder\DependencyInjection\CompilerPass\NamelessConsoleCommandCompilerPass;
final class NamelessConsoleCommandBundle extends \RectorPrefix20210729\Symfony\Component\HttpKernel\Bundle\Bundle
{
    /**
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder
     */
    public function build($containerBuilder) : void
    {
        $containerBuilder->addCompilerPass(new \RectorPrefix20210729\Symplify\ConsolePackageBuilder\DependencyInjection\CompilerPass\NamelessConsoleCommandCompilerPass());
    }
}
