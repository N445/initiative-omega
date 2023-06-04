<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221221223951 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ship_info (id INT AUTO_INCREMENT NOT NULL, avionic_id INT DEFAULT NULL, modular_id INT DEFAULT NULL, propulsion_id INT DEFAULT NULL, thruster_id INT DEFAULT NULL, weapon_id INT DEFAULT NULL, afterburner_speed INT DEFAULT NULL, beam DOUBLE PRECISION DEFAULT NULL, cargocapacity INT DEFAULT NULL, chassis_id INT NOT NULL, height DOUBLE PRECISION NOT NULL, length DOUBLE PRECISION NOT NULL, mass INT DEFAULT NULL, max_crew INT DEFAULT NULL, min_crew INT DEFAULT NULL, pitch_max DOUBLE PRECISION DEFAULT NULL, production_note VARCHAR(255) DEFAULT NULL, production_status VARCHAR(255) NOT NULL, roll_max DOUBLE PRECISION DEFAULT NULL, scm_speed INT DEFAULT NULL, size VARCHAR(255) DEFAULT NULL, time_modified VARCHAR(255) NOT NULL COMMENT \'(DC2Type:dateinterval)\', type VARCHAR(255) NOT NULL, xaxis_acceleration DOUBLE PRECISION DEFAULT NULL, yaw_max DOUBLE PRECISION DEFAULT NULL, yaxis_acceleration DOUBLE PRECISION DEFAULT NULL, zaxis_acceleration DOUBLE PRECISION DEFAULT NULL, description LONGTEXT DEFAULT NULL, time_modified_date DATETIME NOT NULL, UNIQUE INDEX UNIQ_69ABE216FA030522 (avionic_id), UNIQUE INDEX UNIQ_69ABE2162DEA1DE7 (modular_id), UNIQUE INDEX UNIQ_69ABE216DE0419CF (propulsion_id), UNIQUE INDEX UNIQ_69ABE216997EA9D7 (thruster_id), UNIQUE INDEX UNIQ_69ABE21695B82273 (weapon_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ship_info_avionic (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ship_info_component (id INT AUTO_INCREMENT NOT NULL, avionic_id INT DEFAULT NULL, modular_id INT DEFAULT NULL, propulsion_id INT DEFAULT NULL, thruster_id INT DEFAULT NULL, weapon_id INT DEFAULT NULL, type VARCHAR(255) DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, mounts INT NOT NULL, component_size VARCHAR(255) DEFAULT NULL, size VARCHAR(255) DEFAULT NULL, details VARCHAR(255) DEFAULT NULL, quantity INT DEFAULT NULL, manufacturer VARCHAR(255) DEFAULT NULL, component_class VARCHAR(255) DEFAULT NULL, INDEX IDX_D31BAA64FA030522 (avionic_id), INDEX IDX_D31BAA642DEA1DE7 (modular_id), INDEX IDX_D31BAA64DE0419CF (propulsion_id), INDEX IDX_D31BAA64997EA9D7 (thruster_id), INDEX IDX_D31BAA6495B82273 (weapon_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ship_info_modular (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ship_info_propulsion (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ship_info_thruster (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ship_info_weapon (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ship_info ADD CONSTRAINT FK_69ABE216FA030522 FOREIGN KEY (avionic_id) REFERENCES ship_info_avionic (id)');
        $this->addSql('ALTER TABLE ship_info ADD CONSTRAINT FK_69ABE2162DEA1DE7 FOREIGN KEY (modular_id) REFERENCES ship_info_modular (id)');
        $this->addSql('ALTER TABLE ship_info ADD CONSTRAINT FK_69ABE216DE0419CF FOREIGN KEY (propulsion_id) REFERENCES ship_info_propulsion (id)');
        $this->addSql('ALTER TABLE ship_info ADD CONSTRAINT FK_69ABE216997EA9D7 FOREIGN KEY (thruster_id) REFERENCES ship_info_thruster (id)');
        $this->addSql('ALTER TABLE ship_info ADD CONSTRAINT FK_69ABE21695B82273 FOREIGN KEY (weapon_id) REFERENCES ship_info_weapon (id)');
        $this->addSql('ALTER TABLE ship_info_component ADD CONSTRAINT FK_D31BAA64FA030522 FOREIGN KEY (avionic_id) REFERENCES ship_info_avionic (id)');
        $this->addSql('ALTER TABLE ship_info_component ADD CONSTRAINT FK_D31BAA642DEA1DE7 FOREIGN KEY (modular_id) REFERENCES ship_info_modular (id)');
        $this->addSql('ALTER TABLE ship_info_component ADD CONSTRAINT FK_D31BAA64DE0419CF FOREIGN KEY (propulsion_id) REFERENCES ship_info_propulsion (id)');
        $this->addSql('ALTER TABLE ship_info_component ADD CONSTRAINT FK_D31BAA64997EA9D7 FOREIGN KEY (thruster_id) REFERENCES ship_info_thruster (id)');
        $this->addSql('ALTER TABLE ship_info_component ADD CONSTRAINT FK_D31BAA6495B82273 FOREIGN KEY (weapon_id) REFERENCES ship_info_weapon (id)');
        $this->addSql('ALTER TABLE ship ADD info_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE ship ADD CONSTRAINT FK_FA30EB245D8BC1F8 FOREIGN KEY (info_id) REFERENCES ship_info (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_FA30EB245D8BC1F8 ON ship (info_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ship DROP FOREIGN KEY FK_FA30EB245D8BC1F8');
        $this->addSql('ALTER TABLE ship_info DROP FOREIGN KEY FK_69ABE216FA030522');
        $this->addSql('ALTER TABLE ship_info DROP FOREIGN KEY FK_69ABE2162DEA1DE7');
        $this->addSql('ALTER TABLE ship_info DROP FOREIGN KEY FK_69ABE216DE0419CF');
        $this->addSql('ALTER TABLE ship_info DROP FOREIGN KEY FK_69ABE216997EA9D7');
        $this->addSql('ALTER TABLE ship_info DROP FOREIGN KEY FK_69ABE21695B82273');
        $this->addSql('ALTER TABLE ship_info_component DROP FOREIGN KEY FK_D31BAA64FA030522');
        $this->addSql('ALTER TABLE ship_info_component DROP FOREIGN KEY FK_D31BAA642DEA1DE7');
        $this->addSql('ALTER TABLE ship_info_component DROP FOREIGN KEY FK_D31BAA64DE0419CF');
        $this->addSql('ALTER TABLE ship_info_component DROP FOREIGN KEY FK_D31BAA64997EA9D7');
        $this->addSql('ALTER TABLE ship_info_component DROP FOREIGN KEY FK_D31BAA6495B82273');
        $this->addSql('DROP TABLE ship_info');
        $this->addSql('DROP TABLE ship_info_avionic');
        $this->addSql('DROP TABLE ship_info_component');
        $this->addSql('DROP TABLE ship_info_modular');
        $this->addSql('DROP TABLE ship_info_propulsion');
        $this->addSql('DROP TABLE ship_info_thruster');
        $this->addSql('DROP TABLE ship_info_weapon');
        $this->addSql('DROP INDEX UNIQ_FA30EB245D8BC1F8 ON ship');
        $this->addSql('ALTER TABLE ship DROP info_id');
    }
}
