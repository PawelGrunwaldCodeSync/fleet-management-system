<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Create new table fleet_vehicle.
 */
final class Version20250730132602 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create new table for relation many to many between fleet and vehicle entities';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('
            CREATE TABLE fleet_vehicle (
                fleet_id INT NOT NULL,
                vehicle_id INT NOT NULL,
                INDEX IDX_3DD2DF8D4B061DF9 (fleet_id),
                INDEX IDX_3DD2DF8D545317D1 (vehicle_id),
                PRIMARY KEY(fleet_id, vehicle_id)
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        ');
        $this->addSql('ALTER TABLE fleet_vehicle ADD CONSTRAINT FK_3DD2DF8D4B061DF9 FOREIGN KEY (fleet_id) REFERENCES fleet (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE fleet_vehicle ADD CONSTRAINT FK_3DD2DF8D545317D1 FOREIGN KEY (vehicle_id) REFERENCES vehicle (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE fleet_vehicle DROP FOREIGN KEY FK_3DD2DF8D4B061DF9');
        $this->addSql('ALTER TABLE fleet_vehicle DROP FOREIGN KEY FK_3DD2DF8D545317D1');
        $this->addSql('DROP TABLE fleet_vehicle');
    }
}
