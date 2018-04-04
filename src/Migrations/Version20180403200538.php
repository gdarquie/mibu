<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180403200538 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE evenement_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE personnage_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('ALTER TABLE evenement ADD item_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE evenement ADD annee_debut INT NOT NULL');
        $this->addSql('ALTER TABLE evenement ADD annee_fin INT NOT NULL');
        $this->addSql('ALTER TABLE evenement ADD CONSTRAINT FK_B26681E126F525E FOREIGN KEY (item_id) REFERENCES item (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B26681E126F525E ON evenement (item_id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE evenement_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE personnage_id_seq CASCADE');
        $this->addSql('ALTER TABLE evenement DROP CONSTRAINT FK_B26681E126F525E');
        $this->addSql('DROP INDEX UNIQ_B26681E126F525E');
        $this->addSql('ALTER TABLE evenement DROP item_id');
        $this->addSql('ALTER TABLE evenement DROP annee_debut');
        $this->addSql('ALTER TABLE evenement DROP annee_fin');
    }
}
