<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240612094301 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE album ADD parent_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE album ADD CONSTRAINT FK_39986E43727ACA70 FOREIGN KEY (parent_id) REFERENCES users (id)');
        $this->addSql('CREATE INDEX IDX_39986E43727ACA70 ON album (parent_id)');
        $this->addSql('ALTER TABLE announces ADD parent_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE announces ADD CONSTRAINT FK_3B879C65727ACA70 FOREIGN KEY (parent_id) REFERENCES users (id)');
        $this->addSql('CREATE INDEX IDX_3B879C65727ACA70 ON announces (parent_id)');
        $this->addSql('ALTER TABLE meetings ADD parent_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE meetings ADD CONSTRAINT FK_44FE52E2727ACA70 FOREIGN KEY (parent_id) REFERENCES users (id)');
        $this->addSql('CREATE INDEX IDX_44FE52E2727ACA70 ON meetings (parent_id)');
        $this->addSql('ALTER TABLE orders ADD parent_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEE727ACA70 FOREIGN KEY (parent_id) REFERENCES users (id)');
        $this->addSql('CREATE INDEX IDX_E52FFDEE727ACA70 ON orders (parent_id)');
        $this->addSql('ALTER TABLE reviews ADD parent_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reviews ADD CONSTRAINT FK_6970EB0F727ACA70 FOREIGN KEY (parent_id) REFERENCES users (id)');
        $this->addSql('CREATE INDEX IDX_6970EB0F727ACA70 ON reviews (parent_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE album DROP FOREIGN KEY FK_39986E43727ACA70');
        $this->addSql('DROP INDEX IDX_39986E43727ACA70 ON album');
        $this->addSql('ALTER TABLE album DROP parent_id');
        $this->addSql('ALTER TABLE announces DROP FOREIGN KEY FK_3B879C65727ACA70');
        $this->addSql('DROP INDEX IDX_3B879C65727ACA70 ON announces');
        $this->addSql('ALTER TABLE announces DROP parent_id');
        $this->addSql('ALTER TABLE meetings DROP FOREIGN KEY FK_44FE52E2727ACA70');
        $this->addSql('DROP INDEX IDX_44FE52E2727ACA70 ON meetings');
        $this->addSql('ALTER TABLE meetings DROP parent_id');
        $this->addSql('ALTER TABLE orders DROP FOREIGN KEY FK_E52FFDEE727ACA70');
        $this->addSql('DROP INDEX IDX_E52FFDEE727ACA70 ON orders');
        $this->addSql('ALTER TABLE orders DROP parent_id');
        $this->addSql('ALTER TABLE reviews DROP FOREIGN KEY FK_6970EB0F727ACA70');
        $this->addSql('DROP INDEX IDX_6970EB0F727ACA70 ON reviews');
        $this->addSql('ALTER TABLE reviews DROP parent_id');
    }
}
