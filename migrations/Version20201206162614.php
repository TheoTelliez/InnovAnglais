<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201206162614 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE abonnements ADD utilisateur_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE abonnements ADD CONSTRAINT FK_4788B767FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('CREATE INDEX IDX_4788B767FB88E14F ON abonnements (utilisateur_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE abonnements DROP FOREIGN KEY FK_4788B767FB88E14F');
        $this->addSql('DROP INDEX IDX_4788B767FB88E14F ON abonnements');
        $this->addSql('ALTER TABLE abonnements DROP utilisateur_id');
    }
}
