<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Create new table Vehicle.
 */
final class Version20250730122326 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create new table of Vehicle entity';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('
            CREATE TABLE vehicle (
                id INT AUTO_INCREMENT NOT NULL,
                registration_number VARCHAR(20) NOT NULL,
                driver VARCHAR(100) NOT NULL,
                created_at DATETIME NOT NULL,
                updated_at DATETIME NOT NULL,
                PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        ');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE vehicle');
    }
}
