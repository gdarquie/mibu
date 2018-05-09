<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180509012911 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE partie_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE partie (id INT NOT NULL, racine INT DEFAULT NULL, parent_id INT DEFAULT NULL, gauche INT NOT NULL, droite INT NOT NULL, niveau INT NOT NULL, date_creation TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, date_modification TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, uuid UUID NOT NULL, titre VARCHAR(255) NOT NULL, description TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_59B1F3DFB492828 ON partie (racine)');
        $this->addSql('CREATE INDEX IDX_59B1F3D727ACA70 ON partie (parent_id)');
        $this->addSql('ALTER TABLE partie ADD CONSTRAINT FK_59B1F3DFB492828 FOREIGN KEY (racine) REFERENCES partie (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE partie ADD CONSTRAINT FK_59B1F3D727ACA70 FOREIGN KEY (parent_id) REFERENCES partie (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE partie DROP CONSTRAINT FK_59B1F3DFB492828');
        $this->addSql('ALTER TABLE partie DROP CONSTRAINT FK_59B1F3D727ACA70');
        $this->addSql('DROP SEQUENCE partie_id_seq CASCADE');
        $this->addSql('DROP TABLE partie');
    }
}
