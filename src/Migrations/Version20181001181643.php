<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181001181643 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE inscrit ADD pseudo VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE inscrit ADD roles JSON NOT NULL');
        $this->addSql('ALTER TABLE inscrit ALTER email TYPE VARCHAR(180)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_927FA36586CC499D ON inscrit (pseudo)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP INDEX UNIQ_927FA36586CC499D');
        $this->addSql('ALTER TABLE inscrit DROP pseudo');
        $this->addSql('ALTER TABLE inscrit DROP roles');
        $this->addSql('ALTER TABLE inscrit ALTER email TYPE VARCHAR(255)');
    }
}
