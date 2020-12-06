<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201206171716 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE liste ADD theme_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE liste ADD CONSTRAINT FK_FCF22AF459027487 FOREIGN KEY (theme_id) REFERENCES theme (id)');
        $this->addSql('CREATE INDEX IDX_FCF22AF459027487 ON liste (theme_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE liste DROP FOREIGN KEY FK_FCF22AF459027487');
        $this->addSql('DROP INDEX IDX_FCF22AF459027487 ON liste');
        $this->addSql('ALTER TABLE liste DROP theme_id');
    }
}
