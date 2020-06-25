<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200419172613 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf('mysql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE medicine (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, price INT NOT NULL, weight INT NOT NULL, is_recipe_required TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE medicine_substance (medicine_id INT NOT NULL, substance_id INT NOT NULL, INDEX IDX_FEA11DA22F7D140A (medicine_id), INDEX IDX_FEA11DA2C707E018 (substance_id), PRIMARY KEY(medicine_id, substance_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE substance (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE medicine_substance ADD CONSTRAINT FK_FEA11DA22F7D140A FOREIGN KEY (medicine_id) REFERENCES medicine (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE medicine_substance ADD CONSTRAINT FK_FEA11DA2C707E018 FOREIGN KEY (substance_id) REFERENCES substance (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf('mysql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE medicine_substance DROP FOREIGN KEY FK_FEA11DA22F7D140A');
        $this->addSql('ALTER TABLE medicine_substance DROP FOREIGN KEY FK_FEA11DA2C707E018');
        $this->addSql('DROP TABLE medicine');
        $this->addSql('DROP TABLE medicine_substance');
        $this->addSql('DROP TABLE substance');
    }
}
