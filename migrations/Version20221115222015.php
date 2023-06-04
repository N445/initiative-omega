<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221115222015 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE event (id INT AUTO_INCREMENT NOT NULL, rrule_id INT DEFAULT NULL, created_by_id INT DEFAULT NULL, type_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, start_at DATETIME NOT NULL, end_at DATETIME NOT NULL, duration VARCHAR(255) NOT NULL COMMENT \'(DC2Type:dateinterval)\', content LONGTEXT NOT NULL, has_rrule TINYINT(1) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', image VARCHAR(255) DEFAULT NULL, updated_at DATETIME NOT NULL, is_private TINYINT(1) NOT NULL, available_for JSON DEFAULT NULL, location VARCHAR(255) DEFAULT NULL, theme VARCHAR(255) DEFAULT NULL, extra_info_organisation JSON DEFAULT NULL, UNIQUE INDEX UNIQ_3BAE0AA7627595AB (rrule_id), INDEX IDX_3BAE0AA7B03A8386 (created_by_id), INDEX IDX_3BAE0AA7C54C8C93 (type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event_date (id INT AUTO_INCREMENT NOT NULL, event_id INT DEFAULT NULL, start_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', end_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_B5557BD171F7E88B (event_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event_rrule (id INT AUTO_INCREMENT NOT NULL, is_infinite TINYINT(1) NOT NULL, frequency VARCHAR(255) NOT NULL, dtstart DATETIME DEFAULT NULL, frequency_interval INT DEFAULT NULL, wkst VARCHAR(255) DEFAULT NULL, count INT DEFAULT NULL, until DATETIME DEFAULT NULL, bymonth JSON DEFAULT NULL, byweekno JSON DEFAULT NULL, byyearday JSON DEFAULT NULL, bymonthday JSON DEFAULT NULL, byday JSON DEFAULT NULL, byhour JSON DEFAULT NULL, byminute JSON DEFAULT NULL, bysecond JSON DEFAULT NULL, bysetpos JSON DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, code VARCHAR(255) NOT NULL, content LONGTEXT DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', color VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA7627595AB FOREIGN KEY (rrule_id) REFERENCES event_rrule (id)');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA7B03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA7C54C8C93 FOREIGN KEY (type_id) REFERENCES event_type (id)');
        $this->addSql('ALTER TABLE event_date ADD CONSTRAINT FK_B5557BD171F7E88B FOREIGN KEY (event_id) REFERENCES event (id)');
        $this->addSql('ALTER TABLE user ADD front_name VARCHAR(255) NOT NULL, ADD signature LONGTEXT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA7627595AB');
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA7B03A8386');
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA7C54C8C93');
        $this->addSql('ALTER TABLE event_date DROP FOREIGN KEY FK_B5557BD171F7E88B');
        $this->addSql('DROP TABLE event');
        $this->addSql('DROP TABLE event_date');
        $this->addSql('DROP TABLE event_rrule');
        $this->addSql('DROP TABLE event_type');
        $this->addSql('ALTER TABLE user DROP front_name, DROP signature');
    }
}
