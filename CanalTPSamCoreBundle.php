<?php

namespace CanalTP\SamCoreBundle;

use CanalTP\SamCoreBundle\DependencyInjection\Compiler\DoctrineEntityListenerPass;
use CanalTP\SamEcoreApplicationManagerBundle\SamApplication;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class CanalTPSamCoreBundle extends Bundle implements SamApplication
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new DoctrineEntityListenerPass());
    }

    /**
     * {@inheritdoc}
     */
    public function getCanonicalName()
    {
        return 'samcore';
    }
}
