<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210623084341 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE artist ADD category_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE artist ADD CONSTRAINT FK_159968712469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('CREATE INDEX IDX_159968712469DE2 ON artist (category_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE artist DROP FOREIGN KEY FK_159968712469DE2');
        $this->addSql('DROP INDEX IDX_159968712469DE2 ON artist');
        $this->addSql('ALTER TABLE artist DROP category_id');
    }
}
