<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220918123637 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE exploit_ship (exploit_id INT NOT NULL, ship_id INT NOT NULL, INDEX IDX_25BA013D6FA4F2D4 (exploit_id), INDEX IDX_25BA013DC256317D (ship_id), PRIMARY KEY(exploit_id, ship_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE exploit_manufacturer (exploit_id INT NOT NULL, manufacturer_id INT NOT NULL, INDEX IDX_4DA0EAB36FA4F2D4 (exploit_id), INDEX IDX_4DA0EAB3A23B42D (manufacturer_id), PRIMARY KEY(exploit_id, manufacturer_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE exploit_ship ADD CONSTRAINT FK_25BA013D6FA4F2D4 FOREIGN KEY (exploit_id) REFERENCES exploit (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE exploit_ship ADD CONSTRAINT FK_25BA013DC256317D FOREIGN KEY (ship_id) REFERENCES ship (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE exploit_manufacturer ADD CONSTRAINT FK_4DA0EAB36FA4F2D4 FOREIGN KEY (exploit_id) REFERENCES exploit (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE exploit_manufacturer ADD CONSTRAINT FK_4DA0EAB3A23B42D FOREIGN KEY (manufacturer_id) REFERENCES manufacturer (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE exploit_ship DROP FOREIGN KEY FK_25BA013D6FA4F2D4');
        $this->addSql('ALTER TABLE exploit_ship DROP FOREIGN KEY FK_25BA013DC256317D');
        $this->addSql('ALTER TABLE exploit_manufacturer DROP FOREIGN KEY FK_4DA0EAB36FA4F2D4');
        $this->addSql('ALTER TABLE exploit_manufacturer DROP FOREIGN KEY FK_4DA0EAB3A23B42D');
        $this->addSql('DROP TABLE exploit_ship');
        $this->addSql('DROP TABLE exploit_manufacturer');
    }
}
