<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181029225701 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE action ALTER cle DROP NOT NULL');
        $this->addSql('INSERT INTO public.inscrit (id, nom, prenom, genre, date_naissance, email, date_creation, date_modification, uuid, titre, description, pseudo, roles, password) VALUES (74, \'Tian\', \'Gao\', \'homme\', \'1950-01-01\', \'gaokita@gmail.com\', \'2018-10-02 20:25:12\', \'2018-10-02 20:25:12\', \'1ac83372-6e63-4b95-8d58-b8dd3a482d16\', \'Titre d\'\'inscrit\', \'Description 1\', \'gaotian\', \'[]\', \'$2y$13$gkWX8N6OcZK.6URwU2c2Yu426CT0H56n1NxWCGkEAgmXiw1yMbDha\');
');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE action ALTER cle SET NOT NULL');
    }
}
