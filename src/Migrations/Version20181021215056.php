<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181021215056 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE action_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE action (id INT NOT NULL, personnage_id INT NOT NULL, cle VARCHAR(12) NOT NULL, debut TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, fin TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, date_creation TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, date_modification TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, uuid UUID NOT NULL, titre VARCHAR(255) NOT NULL, description TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_47CC8C925E315342 ON action (personnage_id)');
        $this->addSql('ALTER TABLE action ADD CONSTRAINT FK_47CC8C925E315342 FOREIGN KEY (personnage_id) REFERENCES personnage (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE action_id_seq CASCADE');
        $this->addSql('DROP TABLE action');
    }
}
