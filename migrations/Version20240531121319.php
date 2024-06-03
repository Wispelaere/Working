<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240531121319 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE announces (id INT AUTO_INCREMENT NOT NULL, name_announce VARCHAR(150) NOT NULL, description_announce LONGTEXT NOT NULL, date_sent DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE meals (id INT AUTO_INCREMENT NOT NULL, name_meal VARCHAR(255) NOT NULL, description_meal LONGTEXT DEFAULT NULL, price_meal NUMERIC(10, 2) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE meetings (id INT AUTO_INCREMENT NOT NULL, name_meeting VARCHAR(150) NOT NULL, date_meeting DATE NOT NULL, time_meeting TIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE menus (id INT AUTO_INCREMENT NOT NULL, name_menu INT NOT NULL, description LONGTEXT DEFAULT NULL, price_menu NUMERIC(10, 2) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE menus_meals (menus_id INT NOT NULL, meals_id INT NOT NULL, INDEX IDX_B34B014614041B84 (menus_id), INDEX IDX_B34B014688A25CA2 (meals_id), PRIMARY KEY(menus_id, meals_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE orders (id INT AUTO_INCREMENT NOT NULL, name_order INT DEFAULT NULL, date_order VARCHAR(50) NOT NULL, statut_command VARCHAR(255) DEFAULT \'en_attente\' NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE orders_meals (orders_id INT NOT NULL, meals_id INT NOT NULL, INDEX IDX_A383494BCFFE9AD6 (orders_id), INDEX IDX_A383494B88A25CA2 (meals_id), PRIMARY KEY(orders_id, meals_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE orders_menus (orders_id INT NOT NULL, menus_id INT NOT NULL, INDEX IDX_33DFA76ECFFE9AD6 (orders_id), INDEX IDX_33DFA76E14041B84 (menus_id), PRIMARY KEY(orders_id, menus_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reviews (id INT AUTO_INCREMENT NOT NULL, title_review VARCHAR(150) NOT NULL, note VARBINARY(255) NOT NULL, description_review LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, is_admin TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE menus_meals ADD CONSTRAINT FK_B34B014614041B84 FOREIGN KEY (menus_id) REFERENCES menus (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE menus_meals ADD CONSTRAINT FK_B34B014688A25CA2 FOREIGN KEY (meals_id) REFERENCES meals (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE orders_meals ADD CONSTRAINT FK_A383494BCFFE9AD6 FOREIGN KEY (orders_id) REFERENCES orders (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE orders_meals ADD CONSTRAINT FK_A383494B88A25CA2 FOREIGN KEY (meals_id) REFERENCES meals (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE orders_menus ADD CONSTRAINT FK_33DFA76ECFFE9AD6 FOREIGN KEY (orders_id) REFERENCES orders (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE orders_menus ADD CONSTRAINT FK_33DFA76E14041B84 FOREIGN KEY (menus_id) REFERENCES menus (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE menus_meals DROP FOREIGN KEY FK_B34B014614041B84');
        $this->addSql('ALTER TABLE menus_meals DROP FOREIGN KEY FK_B34B014688A25CA2');
        $this->addSql('ALTER TABLE orders_meals DROP FOREIGN KEY FK_A383494BCFFE9AD6');
        $this->addSql('ALTER TABLE orders_meals DROP FOREIGN KEY FK_A383494B88A25CA2');
        $this->addSql('ALTER TABLE orders_menus DROP FOREIGN KEY FK_33DFA76ECFFE9AD6');
        $this->addSql('ALTER TABLE orders_menus DROP FOREIGN KEY FK_33DFA76E14041B84');
        $this->addSql('DROP TABLE announces');
        $this->addSql('DROP TABLE meals');
        $this->addSql('DROP TABLE meetings');
        $this->addSql('DROP TABLE menus');
        $this->addSql('DROP TABLE menus_meals');
        $this->addSql('DROP TABLE orders');
        $this->addSql('DROP TABLE orders_meals');
        $this->addSql('DROP TABLE orders_menus');
        $this->addSql('DROP TABLE reviews');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
