<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180509102818 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE partie DROP CONSTRAINT fk_59b1f3dfb492828');
        $this->addSql('ALTER TABLE partie DROP CONSTRAINT FK_59B1F3D727ACA70');
        $this->addSql('DROP INDEX idx_59b1f3dfb492828');
        $this->addSql('ALTER TABLE partie ADD title VARCHAR(64) NOT NULL');
        $this->addSql('ALTER TABLE partie ADD lft INT NOT NULL');
        $this->addSql('ALTER TABLE partie ADD lvl INT NOT NULL');
        $this->addSql('ALTER TABLE partie ADD rgt INT NOT NULL');
        $this->addSql('ALTER TABLE partie DROP gauche');
        $this->addSql('ALTER TABLE partie DROP droite');
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
        $this->addSql('ALTER TABLE partie DROP CONSTRAINT FK_59B1F3DA977936C');
        $this->addSql('ALTER TABLE partie DROP CONSTRAINT fk_59b1f3d727aca70');
        $this->addSql('DROP INDEX IDX_59B1F3DA977936C');
        $this->addSql('ALTER TABLE partie ADD gauche INT NOT NULL');
        $this->addSql('ALTER TABLE partie ADD droite INT NOT NULL');
        $this->addSql('ALTER TABLE partie ADD niveau INT NOT NULL');
        $this->addSql('ALTER TABLE partie DROP title');
        $this->addSql('ALTER TABLE partie DROP lft');
        $this->addSql('ALTER TABLE partie DROP lvl');
        $this->addSql('ALTER TABLE partie DROP rgt');
        $this->addSql('ALTER TABLE partie RENAME COLUMN tree_root TO racine');
        $this->addSql('ALTER TABLE partie ADD CONSTRAINT fk_59b1f3dfb492828 FOREIGN KEY (racine) REFERENCES partie (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE partie ADD CONSTRAINT fk_59b1f3d727aca70 FOREIGN KEY (parent_id) REFERENCES partie (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_59b1f3dfb492828 ON partie (racine)');
    }
}
