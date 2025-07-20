<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250720170129_CreateCartsItemsTable extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE carts_items (id UUID NOT NULL, product_id UUID NOT NULL, cart_id UUID NOT NULL, amount SMALLINT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_6DBF34664584665A ON carts_items (product_id)');
        $this->addSql('CREATE INDEX IDX_6DBF34661AD5CDBF ON carts_items (cart_id)');
        $this->addSql('COMMENT ON COLUMN carts_items.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN carts_items.product_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN carts_items.cart_id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE carts_items ADD CONSTRAINT FK_6DBF34664584665A FOREIGN KEY (product_id) REFERENCES products (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE carts_items ADD CONSTRAINT FK_6DBF34661AD5CDBF FOREIGN KEY (cart_id) REFERENCES carts (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE carts_items DROP CONSTRAINT FK_6DBF34664584665A');
        $this->addSql('ALTER TABLE carts_items DROP CONSTRAINT FK_6DBF34661AD5CDBF');
        $this->addSql('DROP TABLE carts_items');
    }
}
