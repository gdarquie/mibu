<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180513102118 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE item_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE texte_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE fiction_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE ext_log_entries_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE item (id INT NOT NULL, fiction_id INT DEFAULT NULL, date_creation TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, date_modification TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, uuid UUID NOT NULL, titre VARCHAR(255) NOT NULL, description TEXT NOT NULL, discr VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_1F1B251EFF905AC2 ON item (fiction_id)');
        $this->addSql('CREATE TABLE partie (id INT NOT NULL, tree_root INT DEFAULT NULL, parent_id INT DEFAULT NULL, lft INT NOT NULL, rgt INT NOT NULL, lvl INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_59B1F3DA977936C ON partie (tree_root)');
        $this->addSql('CREATE INDEX IDX_59B1F3D727ACA70 ON partie (parent_id)');
        $this->addSql('CREATE TABLE evenement (id INT NOT NULL, annee_debut INT NOT NULL, annee_fin INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE personnage (id INT NOT NULL, annee_naissance INT DEFAULT NULL, annee_mort INT DEFAULT NULL, nom VARCHAR(255) DEFAULT NULL, prenom VARCHAR(255) DEFAULT NULL, genre VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE texte (id INT NOT NULL, fiction_id INT DEFAULT NULL, type VARCHAR(255) NOT NULL, date_creation TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, date_modification TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, uuid UUID NOT NULL, titre VARCHAR(255) NOT NULL, description TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_EAE1A6EEFF905AC2 ON texte (fiction_id)');
        $this->addSql('CREATE TABLE fiction (id INT NOT NULL, date_creation TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, date_modification TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, uuid UUID NOT NULL, titre VARCHAR(255) NOT NULL, description TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE ext_translations (id SERIAL NOT NULL, locale VARCHAR(8) NOT NULL, object_class VARCHAR(255) NOT NULL, field VARCHAR(32) NOT NULL, foreign_key VARCHAR(64) NOT NULL, content TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX translations_lookup_idx ON ext_translations (locale, object_class, foreign_key)');
        $this->addSql('CREATE UNIQUE INDEX lookup_unique_idx ON ext_translations (locale, object_class, field, foreign_key)');
        $this->addSql('CREATE TABLE ext_log_entries (id INT NOT NULL, action VARCHAR(8) NOT NULL, logged_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, object_id VARCHAR(64) DEFAULT NULL, object_class VARCHAR(255) NOT NULL, version INT NOT NULL, data TEXT DEFAULT NULL, username VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX log_class_lookup_idx ON ext_log_entries (object_class)');
        $this->addSql('CREATE INDEX log_date_lookup_idx ON ext_log_entries (logged_at)');
        $this->addSql('CREATE INDEX log_user_lookup_idx ON ext_log_entries (username)');
        $this->addSql('CREATE INDEX log_version_lookup_idx ON ext_log_entries (object_id, object_class, version)');
        $this->addSql('COMMENT ON COLUMN ext_log_entries.data IS \'(DC2Type:array)\'');
        $this->addSql('ALTER TABLE item ADD CONSTRAINT FK_1F1B251EFF905AC2 FOREIGN KEY (fiction_id) REFERENCES fiction (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE partie ADD CONSTRAINT FK_59B1F3DA977936C FOREIGN KEY (tree_root) REFERENCES partie (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE partie ADD CONSTRAINT FK_59B1F3D727ACA70 FOREIGN KEY (parent_id) REFERENCES partie (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE partie ADD CONSTRAINT FK_59B1F3DBF396750 FOREIGN KEY (id) REFERENCES item (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE evenement ADD CONSTRAINT FK_B26681EBF396750 FOREIGN KEY (id) REFERENCES item (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE personnage ADD CONSTRAINT FK_6AEA486DBF396750 FOREIGN KEY (id) REFERENCES item (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE texte ADD CONSTRAINT FK_EAE1A6EEFF905AC2 FOREIGN KEY (fiction_id) REFERENCES fiction (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE partie DROP CONSTRAINT FK_59B1F3DBF396750');
        $this->addSql('ALTER TABLE evenement DROP CONSTRAINT FK_B26681EBF396750');
        $this->addSql('ALTER TABLE personnage DROP CONSTRAINT FK_6AEA486DBF396750');
        $this->addSql('ALTER TABLE partie DROP CONSTRAINT FK_59B1F3DA977936C');
        $this->addSql('ALTER TABLE partie DROP CONSTRAINT FK_59B1F3D727ACA70');
        $this->addSql('ALTER TABLE item DROP CONSTRAINT FK_1F1B251EFF905AC2');
        $this->addSql('ALTER TABLE texte DROP CONSTRAINT FK_EAE1A6EEFF905AC2');
        $this->addSql('DROP SEQUENCE item_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE texte_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE fiction_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE ext_log_entries_id_seq CASCADE');
        $this->addSql('DROP TABLE item');
        $this->addSql('DROP TABLE partie');
        $this->addSql('DROP TABLE evenement');
        $this->addSql('DROP TABLE personnage');
        $this->addSql('DROP TABLE texte');
        $this->addSql('DROP TABLE fiction');
        $this->addSql('DROP TABLE ext_translations');
        $this->addSql('DROP TABLE ext_log_entries');
    }
}
