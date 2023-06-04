<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221207182824 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE referral (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(255) NOT NULL, is_enabled TINYINT(1) NOT NULL, is_actual_to_display TINYINT(1) NOT NULL, displayed_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user ADD referral_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6493CCAA4B7 FOREIGN KEY (referral_id) REFERENCES referral (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D6493CCAA4B7 ON user (referral_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6493CCAA4B7');
        $this->addSql('DROP TABLE referral');
        $this->addSql('DROP INDEX UNIQ_8D93D6493CCAA4B7 ON user');
        $this->addSql('ALTER TABLE user DROP referral_id');
    }
}
