<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220730082612 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE blog ADD themes_id INT NOT NULL');
        $this->addSql('ALTER TABLE blog ADD CONSTRAINT FK_C015514394F4A9D2 FOREIGN KEY (themes_id) REFERENCES themes (id)');
        $this->addSql('CREATE INDEX IDX_C015514394F4A9D2 ON blog (themes_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE blog DROP FOREIGN KEY FK_C015514394F4A9D2');
        $this->addSql('DROP INDEX IDX_C015514394F4A9D2 ON blog');
        $this->addSql('ALTER TABLE blog DROP themes_id');
    }
}
