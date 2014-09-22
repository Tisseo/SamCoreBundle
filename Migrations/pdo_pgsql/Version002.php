<?php

namespace CanalTP\SamCoreBundle\Migrations\pdo_pgsql;

use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version002 extends AbstractSamMigration
{
    const VERSION = '0.0.2';

    public function up(Schema $schema)
    {
        $this->skipIf($this->tableExists('migration_versions'), 'No need to do this migration.');

        $this->addSql('ALTER TABLE public.t_role_rol ADD rol_is_editable BOOLEAN NOT NULL DEFAULT TRUE;');
    }

    public function down(Schema $schema)
    {
        $this->addSql('ALTER TABLE public.t_role_rol DROP IF EXISTS rol_is_editable;');
    }

    public function getName()
    {
        return self::VERSION;
    }
}
