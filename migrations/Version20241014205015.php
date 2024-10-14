<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241014205015 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE euromillions (id INT AUTO_INCREMENT NOT NULL, boule_1 INT DEFAULT NULL, boule_2 INT DEFAULT NULL, boule_3 INT DEFAULT NULL, boule_4 INT DEFAULT NULL, boule_5 INT DEFAULT NULL, etoile_1 INT DEFAULT NULL, etoile_2 INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('DROP TABLE euromillions2');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE euromillions2 (id INT AUTO_INCREMENT NOT NULL, boule_1 INT DEFAULT NULL, boule_2 INT DEFAULT NULL, boule_3 INT DEFAULT NULL, boule_4 INT DEFAULT NULL, boule_5 INT DEFAULT NULL, etoile_1 INT DEFAULT NULL, etoile_2 INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_0900_ai_ci` ENGINE = MyISAM COMMENT = \'\' ');
        $this->addSql('DROP TABLE euromillions');
    }
}
