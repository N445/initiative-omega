<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220909173926 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE activity (id INT AUTO_INCREMENT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', title VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, image VARCHAR(255) NOT NULL, display_order INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contact (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(255) NOT NULL, message LONGTEXT NOT NULL, send_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fleet (id INT AUTO_INCREMENT NOT NULL, ship_id INT DEFAULT NULL, user_id INT DEFAULT NULL, number_ships INT NOT NULL, INDEX IDX_A05E1E47C256317D (ship_id), INDEX IDX_A05E1E47A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE guilded_member (id INT AUTO_INCREMENT NOT NULL, guilded_id VARCHAR(10) NOT NULL, name VARCHAR(255) NOT NULL, join_date DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', last_online DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE guilded_member_xp (id INT AUTO_INCREMENT NOT NULL, member_id INT DEFAULT NULL, value INT NOT NULL, date DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_A1F75BED7597D3FE (member_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE info (id INT AUTO_INCREMENT NOT NULL, rsi_name VARCHAR(255) DEFAULT NULL, guilded_name VARCHAR(255) DEFAULT NULL, discord_name VARCHAR(255) DEFAULT NULL, ships JSON NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ship (id INT AUTO_INCREMENT NOT NULL, rsi_id INT NOT NULL, name VARCHAR(255) NOT NULL, type VARCHAR(255) DEFAULT NULL, banner_image VARCHAR(255) NOT NULL, link VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, info_id INT NOT NULL, guilded_account_id INT DEFAULT NULL, email VARCHAR(80) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, is_verified TINYINT(1) NOT NULL, registered_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', lastlogin_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), UNIQUE INDEX UNIQ_8D93D6495D8BC1F8 (info_id), UNIQUE INDEX UNIQ_8D93D6492C4B60FE (guilded_account_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE fleet ADD CONSTRAINT FK_A05E1E47C256317D FOREIGN KEY (ship_id) REFERENCES ship (id)');
        $this->addSql('ALTER TABLE fleet ADD CONSTRAINT FK_A05E1E47A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE guilded_member_xp ADD CONSTRAINT FK_A1F75BED7597D3FE FOREIGN KEY (member_id) REFERENCES guilded_member (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6495D8BC1F8 FOREIGN KEY (info_id) REFERENCES info (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6492C4B60FE FOREIGN KEY (guilded_account_id) REFERENCES guilded_member (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE fleet DROP FOREIGN KEY FK_A05E1E47C256317D');
        $this->addSql('ALTER TABLE fleet DROP FOREIGN KEY FK_A05E1E47A76ED395');
        $this->addSql('ALTER TABLE guilded_member_xp DROP FOREIGN KEY FK_A1F75BED7597D3FE');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6495D8BC1F8');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6492C4B60FE');
        $this->addSql('DROP TABLE activity');
        $this->addSql('DROP TABLE contact');
        $this->addSql('DROP TABLE fleet');
        $this->addSql('DROP TABLE guilded_member');
        $this->addSql('DROP TABLE guilded_member_xp');
        $this->addSql('DROP TABLE info');
        $this->addSql('DROP TABLE ship');
        $this->addSql('DROP TABLE user');
    }
}
