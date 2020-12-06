<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201206171639 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE theme DROP FOREIGN KEY FK_9775E708E85441D8');
        $this->addSql('DROP INDEX IDX_9775E708E85441D8 ON theme');
        $this->addSql('ALTER TABLE theme DROP liste_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE theme ADD liste_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE theme ADD CONSTRAINT FK_9775E708E85441D8 FOREIGN KEY (liste_id) REFERENCES liste (id)');
        $this->addSql('CREATE INDEX IDX_9775E708E85441D8 ON theme (liste_id)');
    }
}
