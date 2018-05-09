<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180509123554 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE ext_log_entries_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE ext_translations (id SERIAL NOT NULL, locale VARCHAR(8) NOT NULL, object_class VARCHAR(255) NOT NULL, field VARCHAR(32) NOT NULL, foreign_key VARCHAR(64) NOT NULL, content TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX translations_lookup_idx ON ext_translations (locale, object_class, foreign_key)');
        $this->addSql('CREATE UNIQUE INDEX lookup_unique_idx ON ext_translations (locale, object_class, field, foreign_key)');
        $this->addSql('CREATE TABLE ext_log_entries (id INT NOT NULL, action VARCHAR(8) NOT NULL, logged_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, object_id VARCHAR(64) DEFAULT NULL, object_class VARCHAR(255) NOT NULL, version INT NOT NULL, data TEXT DEFAULT NULL, username VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX log_class_lookup_idx ON ext_log_entries (object_class)');
        $this->addSql('CREATE INDEX log_date_lookup_idx ON ext_log_entries (logged_at)');
        $this->addSql('CREATE INDEX log_user_lookup_idx ON ext_log_entries (username)');
        $this->addSql('CREATE INDEX log_version_lookup_idx ON ext_log_entries (object_id, object_class, version)');
        $this->addSql('COMMENT ON COLUMN ext_log_entries.data IS \'(DC2Type:array)\'');
        $this->addSql('ALTER TABLE partie DROP CONSTRAINT fk_59b1f3dfb492828');
        $this->addSql('ALTER TABLE partie DROP CONSTRAINT FK_59B1F3D727ACA70');
        $this->addSql('DROP INDEX idx_59b1f3dfb492828');
        $this->addSql('ALTER TABLE partie ADD lft INT NOT NULL');
        $this->addSql('ALTER TABLE partie ADD lvl INT NOT NULL');
        $this->addSql('ALTER TABLE partie ADD rgt INT NOT NULL');
        $this->addSql('ALTER TABLE partie DROP droite');
        $this->addSql('ALTER TABLE partie DROP gauche');
        $this->addSql('ALTER TABLE partie DROP niveau');
        $this->addSql('ALTER TABLE partie RENAME COLUMN racine TO tree_root');
        $this->addSql('ALTER TABLE partie ADD CONSTRAINT FK_59B1F3DA977936C FOREIGN KEY (tree_root) REFERENCES partie (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE partie ADD CONSTRAINT FK_59B1F3D727ACA70 FOREIGN KEY (parent_id) REFERENCES partie (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_59B1F3DA977936C ON partie (tree_root)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE ext_log_entries_id_seq CASCADE');
        $this->addSql('DROP TABLE ext_translations');
        $this->addSql('DROP TABLE ext_log_entries');
        $this->addSql('ALTER TABLE partie DROP CONSTRAINT FK_59B1F3DA977936C');
        $this->addSql('ALTER TABLE partie DROP CONSTRAINT fk_59b1f3d727aca70');
        $this->addSql('DROP INDEX IDX_59B1F3DA977936C');
        $this->addSql('ALTER TABLE partie ADD droite INT NOT NULL');
        $this->addSql('ALTER TABLE partie ADD gauche INT NOT NULL');
        $this->addSql('ALTER TABLE partie ADD niveau INT NOT NULL');
        $this->addSql('ALTER TABLE partie DROP lft');
        $this->addSql('ALTER TABLE partie DROP lvl');
        $this->addSql('ALTER TABLE partie DROP rgt');
        $this->addSql('ALTER TABLE partie RENAME COLUMN tree_root TO racine');
        $this->addSql('ALTER TABLE partie ADD CONSTRAINT fk_59b1f3dfb492828 FOREIGN KEY (racine) REFERENCES partie (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE partie ADD CONSTRAINT fk_59b1f3d727aca70 FOREIGN KEY (parent_id) REFERENCES partie (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_59b1f3dfb492828 ON partie (racine)');
    }
}
