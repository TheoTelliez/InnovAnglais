<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201206171020 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE utilisateur ADD abonnements_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B3633E2BBF FOREIGN KEY (abonnements_id) REFERENCES abonnements (id)');
        $this->addSql('CREATE INDEX IDX_1D1C63B3633E2BBF ON utilisateur (abonnements_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B3633E2BBF');
        $this->addSql('DROP INDEX IDX_1D1C63B3633E2BBF ON utilisateur');
        $this->addSql('ALTER TABLE utilisateur DROP abonnements_id');
    }
}
