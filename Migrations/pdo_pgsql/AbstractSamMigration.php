<?php

namespace CanalTP\SamCoreBundle\Migrations\pdo_pgsql;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

class AbstractSamMigration extends AbstractMigration
{
    protected function tableExists($table, $schema = 'public')
    {
        $statement = $this->connection->prepare("SELECT EXISTS(SELECT 1 FROM pg_catalog.pg_class c JOIN pg_catalog.pg_namespace n ON n.oid = c.relnamespace WHERE n.nspname = '" . $schema . "' AND c.relname = '" . $table . "');");
        $statement->execute();
        $result = $statement->fetchAll();

        return ($result[0]['exists']);
    }

    public function up(Schema $schema)
    {
    }

    public function down(Schema $schema)
    {
    }
}
