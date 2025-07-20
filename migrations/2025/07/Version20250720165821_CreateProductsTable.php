<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250720165821_CreateProductsTable extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE products (id UUID NOT NULL, name VARCHAR(255) NOT NULL, cost INT NOT NULL, description TEXT DEFAULT NULL, tax INT NOT NULL, version INT NOT NULL, height INT NOT NULL, width INT NOT NULL, length INT NOT NULL, weight INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN products.id IS \'(DC2Type:uuid)\'');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE products');
    }
}
