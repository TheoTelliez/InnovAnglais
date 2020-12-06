<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201206171501 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE liste ADD entreprise_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE liste ADD CONSTRAINT FK_FCF22AF4A4AEAFEA FOREIGN KEY (entreprise_id) REFERENCES entreprise (id)');
        $this->addSql('CREATE INDEX IDX_FCF22AF4A4AEAFEA ON liste (entreprise_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE liste DROP FOREIGN KEY FK_FCF22AF4A4AEAFEA');
        $this->addSql('DROP INDEX IDX_FCF22AF4A4AEAFEA ON liste');
        $this->addSql('ALTER TABLE liste DROP entreprise_id');
    }
}
