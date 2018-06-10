<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180702220438 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE item DROP CONSTRAINT FK_1F1B251EFF905AC2');
        $this->addSql('ALTER TABLE item ADD CONSTRAINT FK_1F1B251EFF905AC2 FOREIGN KEY (fiction_id) REFERENCES fiction (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE evenement ALTER annee_debut DROP NOT NULL');
        $this->addSql('ALTER TABLE evenement ALTER annee_fin DROP NOT NULL');
        $this->addSql('ALTER TABLE texte DROP CONSTRAINT FK_EAE1A6EEFF905AC2');
        $this->addSql('ALTER TABLE texte ADD CONSTRAINT FK_EAE1A6EEFF905AC2 FOREIGN KEY (fiction_id) REFERENCES fiction (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE evenement ALTER annee_debut SET NOT NULL');
        $this->addSql('ALTER TABLE evenement ALTER annee_fin SET NOT NULL');
        $this->addSql('ALTER TABLE texte DROP CONSTRAINT fk_eae1a6eeff905ac2');
        $this->addSql('ALTER TABLE texte ADD CONSTRAINT fk_eae1a6eeff905ac2 FOREIGN KEY (fiction_id) REFERENCES fiction (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE item DROP CONSTRAINT fk_1f1b251eff905ac2');
        $this->addSql('ALTER TABLE item ADD CONSTRAINT fk_1f1b251eff905ac2 FOREIGN KEY (fiction_id) REFERENCES fiction (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }
}
