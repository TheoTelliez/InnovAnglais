<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201206171854 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE test ADD theme_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE test ADD CONSTRAINT FK_D87F7E0C59027487 FOREIGN KEY (theme_id) REFERENCES theme (id)');
        $this->addSql('CREATE INDEX IDX_D87F7E0C59027487 ON test (theme_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE test DROP FOREIGN KEY FK_D87F7E0C59027487');
        $this->addSql('DROP INDEX IDX_D87F7E0C59027487 ON test');
        $this->addSql('ALTER TABLE test DROP theme_id');
    }
}
