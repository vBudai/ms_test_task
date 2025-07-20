<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250720170047_CreateCartsTable extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE carts (id UUID NOT NULL, related_user_id UUID NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4E004AAC98771930 ON carts (related_user_id)');
        $this->addSql('COMMENT ON COLUMN carts.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN carts.related_user_id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE carts ADD CONSTRAINT FK_4E004AAC98771930 FOREIGN KEY (related_user_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE carts DROP CONSTRAINT FK_4E004AAC98771930');
        $this->addSql('DROP TABLE carts');
    }
}
