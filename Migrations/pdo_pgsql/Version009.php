<?php

namespace CanalTP\SamCoreBundle\Migrations\pdo_pgsql;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Migrations\AbstractMigration;

class Version009 extends AbstractMigration
{
    const VERSION = '0.0.9';

    public function getName()
    {
        return self::VERSION;
    }

    public function up(Schema $schema)
    {
        $this->addSql("UPDATE tr_application_app SET app_bundle_name = 'CanalTPMttBundle' WHERE app_canonnical_name='mtt'");
        $this->addSql("UPDATE tr_application_app SET app_bundle_name = 'CanalTPMatrixBundle' WHERE app_canonnical_name='matrix'");
        $this->addSql("UPDATE tr_application_app SET app_bundle_name = 'CanalTPNmpAdminBundle' WHERE app_canonnical_name='nmpadmin'");
        $this->addSql("UPDATE tr_application_app SET app_bundle_name = 'CanalTPRealTimeBundle' WHERE app_canonnical_name='realtime'");
        $this->addSql("UPDATE tr_application_app SET app_bundle_name = 'CanalTPNmmPortalBridgeBundle' WHERE app_canonnical_name='samcore'");
    }

    public function down(Schema $schema)
    {
        $this->addSql("UPDATE tr_application_app SET app_bundle_name = 'CanalTPMttBundle' WHERE app_canonnical_name=''");
        $this->addSql("UPDATE tr_application_app SET app_bundle_name = 'CanalTPMatrixBundle' WHERE app_canonnical_name=''");
        $this->addSql("UPDATE tr_application_app SET app_bundle_name = 'CanalTPNmpAdminBundle' WHERE app_canonnical_name=''");
        $this->addSql("UPDATE tr_application_app SET app_bundle_name = 'CanalTPRealTimeBundle' WHERE app_canonnical_name=''");
        $this->addSql("UPDATE tr_application_app SET app_bundle_name = 'CanalTPNmmPortalBridgeBundle' WHERE app_canonnical_name=''");
    }
}

