<?php

namespace CanalTP\SamCoreBundle\Features\Context;

use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\TableNode;
use Behat\Symfony2Extension\Context\KernelDictionary;

/**
 * Defines application features from the specific context.
 */
class DoctrineDbalContext implements SnippetAcceptingContext
{
    use KernelDictionary;

    public function truncateTables(array $tables)
    {
        $connection = $this->getContainer()->get('doctrine.dbal.default_connection');

        foreach ($tables as $table) {
            $connection->executeUpdate(
                $connection->getDatabasePlatform()->getTruncateTableSQL($table, true)
            );
        }
    }

    /**
     * @Given the following data in :dbTable exist:
     */
    public function theFollowingDataInExist($dbTable, TableNode $table)
    {
        $connection = $this->getContainer()->get('doctrine.dbal.default_connection');

        foreach ($table->getHash() as $key => $row) {
            $connection->insert($dbTable, $row);
        }
    }
}
