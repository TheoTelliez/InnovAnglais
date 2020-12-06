<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201206165359 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE realise (id INT AUTO_INCREMENT NOT NULL, test_id INT DEFAULT NULL, utilisateur_id INT DEFAULT NULL, score INT NOT NULL, realiseauj TINYINT(1) NOT NULL, INDEX IDX_15CCD99E1E5D0459 (test_id), INDEX IDX_15CCD99EFB88E14F (utilisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE realise ADD CONSTRAINT FK_15CCD99E1E5D0459 FOREIGN KEY (test_id) REFERENCES test (id)');
        $this->addSql('ALTER TABLE realise ADD CONSTRAINT FK_15CCD99EFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE realise');
    }
}
