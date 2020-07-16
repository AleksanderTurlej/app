<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200716163046 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE disease (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE favourites (id INT AUTO_INCREMENT NOT NULL, medicine_id INT DEFAULT NULL, user_id INT UNSIGNED DEFAULT NULL, INDEX IDX_7F07C5012F7D140A (medicine_id), INDEX IDX_7F07C501A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE medicine (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, price INT NOT NULL, weight INT NOT NULL, is_recipe_required TINYINT(1) NOT NULL, description VARCHAR(255) NOT NULL, upload_file VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE medicine_substance (medicine_id INT NOT NULL, substance_id INT NOT NULL, INDEX IDX_FEA11DA22F7D140A (medicine_id), INDEX IDX_FEA11DA2C707E018 (substance_id), PRIMARY KEY(medicine_id, substance_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE medicine_disease (medicine_id INT NOT NULL, disease_id INT NOT NULL, INDEX IDX_2C01DDF2F7D140A (medicine_id), INDEX IDX_2C01DDFD8355341 (disease_id), PRIMARY KEY(medicine_id, disease_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE opinion (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, medicine_id INT NOT NULL, content VARCHAR(255) NOT NULL, rating INT NOT NULL, INDEX IDX_AB02B027A76ED395 (user_id), INDEX IDX_AB02B0272F7D140A (medicine_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE substance (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT UNSIGNED AUTO_INCREMENT NOT NULL, nick VARCHAR(255) NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX email_idx (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE favourites ADD CONSTRAINT FK_7F07C5012F7D140A FOREIGN KEY (medicine_id) REFERENCES medicine (id)');
        $this->addSql('ALTER TABLE favourites ADD CONSTRAINT FK_7F07C501A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE medicine_substance ADD CONSTRAINT FK_FEA11DA22F7D140A FOREIGN KEY (medicine_id) REFERENCES medicine (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE medicine_substance ADD CONSTRAINT FK_FEA11DA2C707E018 FOREIGN KEY (substance_id) REFERENCES substance (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE medicine_disease ADD CONSTRAINT FK_2C01DDF2F7D140A FOREIGN KEY (medicine_id) REFERENCES medicine (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE medicine_disease ADD CONSTRAINT FK_2C01DDFD8355341 FOREIGN KEY (disease_id) REFERENCES disease (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE opinion ADD CONSTRAINT FK_AB02B027A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE opinion ADD CONSTRAINT FK_AB02B0272F7D140A FOREIGN KEY (medicine_id) REFERENCES medicine (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE medicine_disease DROP FOREIGN KEY FK_2C01DDFD8355341');
        $this->addSql('ALTER TABLE favourites DROP FOREIGN KEY FK_7F07C5012F7D140A');
        $this->addSql('ALTER TABLE medicine_substance DROP FOREIGN KEY FK_FEA11DA22F7D140A');
        $this->addSql('ALTER TABLE medicine_disease DROP FOREIGN KEY FK_2C01DDF2F7D140A');
        $this->addSql('ALTER TABLE opinion DROP FOREIGN KEY FK_AB02B0272F7D140A');
        $this->addSql('ALTER TABLE medicine_substance DROP FOREIGN KEY FK_FEA11DA2C707E018');
        $this->addSql('ALTER TABLE favourites DROP FOREIGN KEY FK_7F07C501A76ED395');
        $this->addSql('ALTER TABLE opinion DROP FOREIGN KEY FK_AB02B027A76ED395');
        $this->addSql('DROP TABLE disease');
        $this->addSql('DROP TABLE favourites');
        $this->addSql('DROP TABLE medicine');
        $this->addSql('DROP TABLE medicine_substance');
        $this->addSql('DROP TABLE medicine_disease');
        $this->addSql('DROP TABLE opinion');
        $this->addSql('DROP TABLE substance');
        $this->addSql('DROP TABLE user');
    }
}
