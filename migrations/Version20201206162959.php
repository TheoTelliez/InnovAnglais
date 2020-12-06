<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201206162959 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE mot_liste (mot_id INT NOT NULL, liste_id INT NOT NULL, INDEX IDX_9DC153B963977652 (mot_id), INDEX IDX_9DC153B9E85441D8 (liste_id), PRIMARY KEY(mot_id, liste_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE mot_liste ADD CONSTRAINT FK_9DC153B963977652 FOREIGN KEY (mot_id) REFERENCES mot (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE mot_liste ADD CONSTRAINT FK_9DC153B9E85441D8 FOREIGN KEY (liste_id) REFERENCES liste (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE mot_liste');
    }
}
