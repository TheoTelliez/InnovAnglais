<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201206162850 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE categorie ADD mot_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE categorie ADD CONSTRAINT FK_497DD63463977652 FOREIGN KEY (mot_id) REFERENCES mot (id)');
        $this->addSql('CREATE INDEX IDX_497DD63463977652 ON categorie (mot_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE categorie DROP FOREIGN KEY FK_497DD63463977652');
        $this->addSql('DROP INDEX IDX_497DD63463977652 ON categorie');
        $this->addSql('ALTER TABLE categorie DROP mot_id');
    }
}
