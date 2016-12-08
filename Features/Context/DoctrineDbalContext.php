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

    /**
     * @Given I have updated the field :field with value :value for condition :condition_field=:condition_value on table :dbTable
     */
    public function iUpdateFieldWithValue($field, $value, $conditionField, $conditionValue, $dbTable)
    {
        $connection = $this->getContainer()->get('doctrine.dbal.default_connection');
        $connection->executeUpdate(
            sprintf("UPDATE %s SET %s='%s' WHERE %s='%s'", $dbTable, $field, $value, $conditionField, $conditionValue)
        );
    }
}
