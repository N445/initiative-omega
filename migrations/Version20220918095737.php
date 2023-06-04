<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220918095737 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE exploit (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', image_name VARCHAR(255) NOT NULL, image_size INT NOT NULL, is_active TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE exploit_tag (exploit_id INT NOT NULL, tag_id INT NOT NULL, INDEX IDX_E98C6D2F6FA4F2D4 (exploit_id), INDEX IDX_E98C6D2FBAD26311 (tag_id), PRIMARY KEY(exploit_id, tag_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tag (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE exploit_tag ADD CONSTRAINT FK_E98C6D2F6FA4F2D4 FOREIGN KEY (exploit_id) REFERENCES exploit (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE exploit_tag ADD CONSTRAINT FK_E98C6D2FBAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE exploit_tag DROP FOREIGN KEY FK_E98C6D2F6FA4F2D4');
        $this->addSql('ALTER TABLE exploit_tag DROP FOREIGN KEY FK_E98C6D2FBAD26311');
        $this->addSql('DROP TABLE exploit');
        $this->addSql('DROP TABLE exploit_tag');
        $this->addSql('DROP TABLE tag');
    }
}
