<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240708104724 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE users ADD confirmation_token VARCHAR(255) DEFAULT NULL, CHANGE adress address VARCHAR(255) NOT NULL');
        $this->addSql('DROP INDEX uniq_1483a5e9e7927c74 ON users');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL ON users (email)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE users DROP confirmation_token, CHANGE address adress VARCHAR(255) NOT NULL');
        $this->addSql('DROP INDEX uniq_identifier_email ON users');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E9E7927C74 ON users (email)');
    }
}
