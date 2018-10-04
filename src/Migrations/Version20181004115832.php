<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181004115832 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE inscrit_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE lieu (id INT NOT NULL, lat NUMERIC(10, 8) NOT NULL, long NUMERIC(10, 8) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE inscrit (id INT NOT NULL, pseudo VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, genre VARCHAR(255) DEFAULT NULL, date_naissance DATE DEFAULT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, date_creation TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, date_modification TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, uuid UUID NOT NULL, titre VARCHAR(255) NOT NULL, description TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_927FA36586CC499D ON inscrit (pseudo)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_927FA365E7927C74 ON inscrit (email)');
        $this->addSql('ALTER TABLE lieu ADD CONSTRAINT FK_2F577D59BF396750 FOREIGN KEY (id) REFERENCES item (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE fiction ADD inscrit_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE fiction ADD CONSTRAINT FK_6F5709FD6DCD4FEE FOREIGN KEY (inscrit_id) REFERENCES inscrit (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_6F5709FD6DCD4FEE ON fiction (inscrit_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE fiction DROP CONSTRAINT FK_6F5709FD6DCD4FEE');
        $this->addSql('DROP SEQUENCE inscrit_id_seq CASCADE');
        $this->addSql('DROP TABLE lieu');
        $this->addSql('DROP TABLE inscrit');
        $this->addSql('DROP INDEX IDX_6F5709FD6DCD4FEE');
        $this->addSql('ALTER TABLE fiction DROP inscrit_id');
    }
}
