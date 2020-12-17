<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201217125900 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD utilisateur_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649FB88E14F ON user (utilisateur_id)');
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B3A76ED395');
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B3F1D74413');
        $this->addSql('DROP INDEX IDX_1D1C63B3F1D74413 ON utilisateur');
        $this->addSql('DROP INDEX UNIQ_1D1C63B3A76ED395 ON utilisateur');
        $this->addSql('ALTER TABLE utilisateur DROP abonnement_id, DROP user_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649FB88E14F');
        $this->addSql('DROP INDEX UNIQ_8D93D649FB88E14F ON user');
        $this->addSql('ALTER TABLE user DROP utilisateur_id');
        $this->addSql('ALTER TABLE utilisateur ADD abonnement_id INT DEFAULT NULL, ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B3A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B3F1D74413 FOREIGN KEY (abonnement_id) REFERENCES abonnements (id)');
        $this->addSql('CREATE INDEX IDX_1D1C63B3F1D74413 ON utilisateur (abonnement_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1D1C63B3A76ED395 ON utilisateur (user_id)');
    }
}
