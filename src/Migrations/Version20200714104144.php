<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200714104144 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE medicine ADD description VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE opinion CHANGE user_id user_id INT NOT NULL, CHANGE medicine_id medicine_id INT NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE medicine DROP description');
        $this->addSql('ALTER TABLE opinion CHANGE user_id user_id INT UNSIGNED DEFAULT NULL, CHANGE medicine_id medicine_id INT DEFAULT NULL');
    }
}
