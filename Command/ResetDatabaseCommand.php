<?php

namespace CanalTP\SamCoreBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Process\Process;

/**
 * Command that purges the database
 *
 * @author David Quintanel <david.quintanel@canaltp.fr>
 */
class ResetDatabaseCommand extends ContainerAwareCommand
{
    private $env = null;
    private $console = null;

    /**
     * {@inheritDoc}
     */
    protected function configure()
    {
        $this
            ->setName('sam:database:reset')
            ->setDescription('Drop and create the database, create the different schemas and load the fixtures')
            ->setHelp(<<<EOT
The <info>sam:database:reset</info> command Drop and create the database,
create the different schemas and load the fixtures:

<info>php app/console sam:database:reset</info>
EOT
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->env = $this->getContainer()->get('kernel')->getEnvironment();
        $this->console = $this->getApplication();

        preg_match_all(
            "|(?P<namespace>[^,]*)\\\(?P<application>[^\\\]*)BridgeBundle|U",
            implode(',', $this->getContainer()->getParameter('kernel.bundles')),
            $bridges,
            PREG_SET_ORDER
        );

        $this->console->setAutoExit(false);
        $this->console->setCatchExceptions(false);
        // Drop the database
        $this->runCommand('doctrine:database:drop', array('--force'  => true), $output);
        // Create the database
        $this->runCommand('doctrine:database:create', array(), $output);
        // Create tables for each aplications
        foreach ($bridges as $bridge) {
            $this->runCommand('claroline:migration:upgrade', array('bundle' => $bridge['namespace'] . $bridge['application'] . "Bundle", '--target' => 'farthest'), $output);
        }
        // Fixtures
        $this->runCommand('doctrine:fixtures:load', array('--append'  => true), $output);
    }

    private function runCommand($command, $arguments, OutputInterface $output)
    {

        $input = new ArrayInput(
            array_merge(
                array('command' => $command),
                array_merge($arguments, array('--env'=> $this->env, '-n' => true))
            )
        );
        try {
            $status = $this->console->run($input, $output);
        } catch (Exception $e) {
            $application->renderException($e, $output);

            $statusCode = $e->getCode();
            $statusCode = is_numeric($statusCode) && $statusCode ? $statusCode : 1;
            exit($statusCode);
        }
    }
}
