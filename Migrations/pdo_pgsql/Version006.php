<?php

namespace CanalTP\SamCoreBundle\Migrations\pdo_pgsql;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Migrations\AbstractMigration;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class Version006 extends AbstractMigration
{
    const VERSION = '0.0.6';

    public function getName()
    {
        return self::VERSION;
    }

    public function up(Schema $schema)
    {
        $this->addSql('CREATE SEQUENCE t_navitia_entity_nav_nav_id_seq INCREMENT BY 1 MINVALUE 1 START 1;');
        $this->addSql('CREATE TABLE t_navitia_entity_nav (nav_id INT NOT NULL, nav_name VARCHAR(255) NOT NULL, nav_name_canonical VARCHAR(255) NOT NULL, nav_email VARCHAR(255) NOT NULL, nav_email_canonical VARCHAR(255) NOT NULL, PRIMARY KEY(nav_id));');
        $this->addSql('CREATE UNIQUE INDEX nav_email_idx ON t_navitia_entity_nav (nav_email_canonical);');
        $this->addSql('ALTER TABLE tr_customer_cus ADD column cus_navitia_entity int default null;');
        $this->addSql('ALTER TABLE tr_customer_cus ADD CONSTRAINT FK_784FEC5FDB6A43B2 FOREIGN KEY (cus_navitia_entity) REFERENCES t_navitia_entity_nav (nav_id) NOT DEFERRABLE INITIALLY IMMEDIATE;');
        $this->addSql('alter table t_perimeter_per rename column cus_id to nav_id;');
        $this->addSql('ALTER TABLE t_perimeter_per DROP CONSTRAINT fk_6b5760dabc4ee2b0;');
        $this->addSql('ALTER TABLE t_perimeter_per ADD CONSTRAINT navitia_entity_id FOREIGN KEY (nav_id) REFERENCES t_navitia_entity_nav (nav_id) MATCH SIMPLE ON UPDATE NO ACTION ON DELETE NO ACTION;');
        $this->addSql('ALTER TABLE tr_customer_cus DROP COLUMN cus_email;');
        $this->addSql('ALTER TABLE tr_customer_cus DROP COLUMN cus_email_canonical;');
        
    }

    public function down(Schema $schema)
    {
        $this->addSql('DROP INDEX cus_email_idx;');
        $this->addSql('DROP SEQUENCE t_navitia_entity_nav_nav_id_seq;');
        $this->addSql('DROP TABLE t_navitia_entity_nav;');
        $this->addSql('alter table t_perimeter_per rename column nav_id to cus_id;');
        $this->addSql('ALTER TABLE t_perimeter_per ADD CONSTRAINT fk_6b5760dabc4ee2b0 FOREIGN KEY (cus_id) REFERENCES tr_customer_cus (cus_id) MATCH SIMPLE ON UPDATE NO ACTION ON DELETE NO ACTION;');
        
        $this->addSql('ALTER TABLE tr_customer_cus ADD COLUMN cus_email character varying(255);');
        $this->addSql('ALTER TABLE tr_customer_cus ALTER COLUMN cus_email SET NOT NULL;');
        
        $this->addSql('ALTER TABLE tr_customer_cus ADD COLUMN cus_email_canonical character varying(255);');
        $this->addSql('ALTER TABLE tr_customer_cus ALTER COLUMN cus_email_canonical SET NOT NULL;');
    }
}

