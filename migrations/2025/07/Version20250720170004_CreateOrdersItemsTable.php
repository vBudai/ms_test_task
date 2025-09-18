<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250720170004_CreateOrdersItemsTable extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE orders_items (id UUID NOT NULL, related_order_id UUID NOT NULL, product_id UUID NOT NULL, amount SMALLINT NOT NULL, cost INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_A0B446EC2B1C2395 ON orders_items (related_order_id)');
        $this->addSql('CREATE INDEX IDX_A0B446EC4584665A ON orders_items (product_id)');
        $this->addSql('COMMENT ON COLUMN orders_items.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN orders_items.related_order_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN orders_items.product_id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE orders_items ADD CONSTRAINT FK_A0B446EC2B1C2395 FOREIGN KEY (related_order_id) REFERENCES orders (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE orders_items ADD CONSTRAINT FK_A0B446EC4584665A FOREIGN KEY (product_id) REFERENCES products (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE orders_items DROP CONSTRAINT FK_A0B446EC2B1C2395');
        $this->addSql('ALTER TABLE orders_items DROP CONSTRAINT FK_A0B446EC4584665A');
        $this->addSql('DROP TABLE orders_items');
    }
}
