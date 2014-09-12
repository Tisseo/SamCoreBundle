<?php

namespace CanalTP\SamCoreBundle\Migrations\pdo_pgsql;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version002 extends AbstractMigration
{
    const VERSION = '0.0.2';

    public function up(Schema $schema)
    {
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
