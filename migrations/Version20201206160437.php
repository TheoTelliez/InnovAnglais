<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201206160437 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE test_utilisateur (test_id INT NOT NULL, utilisateur_id INT NOT NULL, INDEX IDX_4262D80D1E5D0459 (test_id), INDEX IDX_4262D80DFB88E14F (utilisateur_id), PRIMARY KEY(test_id, utilisateur_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE test_utilisateur ADD CONSTRAINT FK_4262D80D1E5D0459 FOREIGN KEY (test_id) REFERENCES test (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE test_utilisateur ADD CONSTRAINT FK_4262D80DFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE test_utilisateur');
    }
}
