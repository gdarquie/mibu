<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180329210906 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE TABLE evenement (id INT NOT NULL, fiction_id INT DEFAULT NULL, date_creation TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, date_modification TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, uuid UUID NOT NULL, titre VARCHAR(255) NOT NULL, description TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_B26681EFF905AC2 ON evenement (fiction_id)');
        $this->addSql('CREATE TABLE personnage (id INT NOT NULL, fiction_id INT DEFAULT NULL, date_creation TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, date_modification TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, uuid UUID NOT NULL, titre VARCHAR(255) NOT NULL, description TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_6AEA486DFF905AC2 ON personnage (fiction_id)');
        $this->addSql('ALTER TABLE evenement ADD CONSTRAINT FK_B26681EFF905AC2 FOREIGN KEY (fiction_id) REFERENCES fiction (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE personnage ADD CONSTRAINT FK_6AEA486DFF905AC2 FOREIGN KEY (fiction_id) REFERENCES fiction (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('DROP TABLE evenement');
        $this->addSql('DROP TABLE personnage');
    }
}
