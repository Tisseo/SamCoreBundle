<?php

namespace CanalTP\SamCoreBundle\Migrations\pdo_pgsql;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version001 extends AbstractMigration
{
    const VERSION = '0.0.1';

    public function getName()
    {
        return self::VERSION;
    }

    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "postgresql", "Migration can only be executed safely on 'postgresql'.");

        $this->addSql('CREATE TABLE public.tr_application_app (app_id SERIAL NOT NULL, app_name VARCHAR(255) NOT NULL, app_canonical_name VARCHAR(255) NOT NULL, app_default_route VARCHAR(255) DEFAULT NULL, PRIMARY KEY(app_id))');
        $this->addSql('CREATE TABLE public.t_role_rol (rol_id SERIAL NOT NULL, app_id INT DEFAULT NULL, rol_name VARCHAR(255) NOT NULL, rol_name_canonical VARCHAR(255) NOT NULL, rol_permissions TEXT DEFAULT NULL, PRIMARY KEY(rol_id))');
        $this->addSql('CREATE INDEX IDX_6ED6A71F7987212D ON public.t_role_rol (app_id)');
        $this->addSql('CREATE TABLE public.t_user_usr (usr_id SERIAL NOT NULL, usr_first_name VARCHAR(255) NOT NULL, usr_last_name VARCHAR(255) NOT NULL, usr_username VARCHAR(255) NOT NULL, usr_username_canonical VARCHAR(255) NOT NULL, usr_email VARCHAR(255) NOT NULL, usr_email_canonical VARCHAR(255) NOT NULL, usr_salt VARCHAR(255) NOT NULL, usr_password VARCHAR(255) NOT NULL, usr_enabled BOOLEAN NOT NULL, usr_locked BOOLEAN NOT NULL, usr_last_login TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, usr_expired BOOLEAN NOT NULL, usr_expires_at BOOLEAN DEFAULT NULL, usr_confirmation_token VARCHAR(255) DEFAULT NULL, usr_password_requested_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, usr_credentials_expired BOOLEAN NOT NULL, usr_credentials_expire_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(usr_id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2895345DB66BC5FE ON public.t_user_usr (usr_username_canonical)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2895345D3E93317B ON public.t_user_usr (usr_email_canonical)');
        $this->addSql('CREATE UNIQUE INDEX username_idx ON public.t_user_usr (usr_username, usr_username_canonical)');
        $this->addSql('CREATE UNIQUE INDEX email_idx ON public.t_user_usr (usr_email, usr_email_canonical)');
        $this->addSql('CREATE TABLE public.tj_user_role_ur (usr_id INT NOT NULL, rol_id INT NOT NULL, PRIMARY KEY(usr_id, rol_id))');
        $this->addSql('CREATE INDEX IDX_CC9B191BC69D3FB ON public.tj_user_role_ur (usr_id)');
        $this->addSql('CREATE INDEX IDX_CC9B191B4BAB96C ON public.tj_user_role_ur (rol_id)');
        $this->addSql('ALTER TABLE public.t_role_rol ADD CONSTRAINT FK_6ED6A71F7987212D FOREIGN KEY (app_id) REFERENCES tr_application_app (app_id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE public.tj_user_role_ur ADD CONSTRAINT FK_CC9B191BC69D3FB FOREIGN KEY (usr_id) REFERENCES t_user_usr (usr_id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE public.tj_user_role_ur ADD CONSTRAINT FK_CC9B191B4BAB96C FOREIGN KEY (rol_id) REFERENCES t_role_rol (rol_id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema)
    {
        $this->addSql('DROP TABLE public.tj_user_role_ur;');
        $this->addSql('DROP TABLE public.t_role_rol;');
        $this->addSql('DROP TABLE public.t_user_usr;');
        $this->addSql('DROP TABLE public.tr_application_app;');
    }
}
