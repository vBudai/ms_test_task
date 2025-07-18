<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250718202251_CreateOrderTable extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE "order" (id SERIAL NOT NULL, related_user_id INT NOT NULL, status VARCHAR(32) NOT NULL, phone VARCHAR(16) NOT NULL, delivery_type VARCHAR(16) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_F529939898771930 ON "order" (related_user_id)');
        $this->addSql('ALTER TABLE "order" ADD CONSTRAINT FK_F529939898771930 FOREIGN KEY (related_user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE "order" DROP CONSTRAINT FK_F529939898771930');
        $this->addSql('DROP TABLE "order"');
    }
}
