<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190625170944 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE market_product_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE category_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE master_product_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE scraper_log_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE prices_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE scraper_check_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE market_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE market_product (id INT NOT NULL, market_id INT NOT NULL, category_id INT DEFAULT NULL, master_product_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, unit enum_unit_type NOT NULL, quantity NUMERIC(10, 2) NOT NULL, amount INT NOT NULL, price_min NUMERIC(10, 2) DEFAULT NULL, price_max NUMERIC(10, 2) DEFAULT NULL, price_avg NUMERIC(10, 2) DEFAULT NULL, price_difference NUMERIC(10, 2) DEFAULT NULL, price_avg_previous NUMERIC(10, 2) DEFAULT NULL, created_by VARCHAR(255) DEFAULT NULL, updated_by VARCHAR(255) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, deleted_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_DADCEC2D622F3F37 ON market_product (market_id)');
        $this->addSql('CREATE INDEX IDX_DADCEC2D12469DE2 ON market_product (category_id)');
        $this->addSql('CREATE INDEX IDX_DADCEC2D4D9AC4D4 ON market_product (master_product_id)');
        $this->addSql('COMMENT ON COLUMN market_product.unit IS \'(DC2Type:enum_unit_type)\'');
        $this->addSql('CREATE TABLE category (id INT NOT NULL, name VARCHAR(255) NOT NULL, created_by VARCHAR(255) DEFAULT NULL, updated_by VARCHAR(255) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, deleted_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE master_product (id INT NOT NULL, name VARCHAR(255) NOT NULL, unit enum_unit_type NOT NULL, quantity NUMERIC(10, 2) NOT NULL, amount INT NOT NULL, image VARCHAR(255) DEFAULT NULL, created_by VARCHAR(255) DEFAULT NULL, updated_by VARCHAR(255) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, deleted_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN master_product.unit IS \'(DC2Type:enum_unit_type)\'');
        $this->addSql('CREATE TABLE scraper_log (id INT NOT NULL, market_id INT NOT NULL, success BOOLEAN NOT NULL, csv_file VARCHAR(255) DEFAULT NULL, error_message VARCHAR(255) DEFAULT NULL, created_by VARCHAR(255) DEFAULT NULL, updated_by VARCHAR(255) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, deleted_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_20D02255622F3F37 ON scraper_log (market_id)');
        $this->addSql('CREATE TABLE prices (id INT NOT NULL, market_product_id INT NOT NULL, price_min NUMERIC(10, 2) NOT NULL, price_max NUMERIC(10, 2) NOT NULL, price_avg NUMERIC(10, 2) NOT NULL, price_difference NUMERIC(10, 2) NOT NULL, created_by VARCHAR(255) DEFAULT NULL, updated_by VARCHAR(255) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, deleted_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_E4CB6D592B7A3246 ON prices (market_product_id)');
        $this->addSql('CREATE TABLE scraper_check (id INT NOT NULL, market_id INT DEFAULT NULL, prices_hash TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_DBC62168622F3F37 ON scraper_check (market_id)');
        $this->addSql('CREATE TABLE market (id INT NOT NULL, name VARCHAR(255) NOT NULL, url VARCHAR(255) NOT NULL, prices_url VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, description TEXT DEFAULT NULL, logo VARCHAR(255) DEFAULT NULL, created_by VARCHAR(255) DEFAULT NULL, updated_by VARCHAR(255) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, deleted_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE market_product ADD CONSTRAINT FK_DADCEC2D622F3F37 FOREIGN KEY (market_id) REFERENCES market (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE market_product ADD CONSTRAINT FK_DADCEC2D12469DE2 FOREIGN KEY (category_id) REFERENCES category (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE market_product ADD CONSTRAINT FK_DADCEC2D4D9AC4D4 FOREIGN KEY (master_product_id) REFERENCES master_product (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE scraper_log ADD CONSTRAINT FK_20D02255622F3F37 FOREIGN KEY (market_id) REFERENCES market (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE prices ADD CONSTRAINT FK_E4CB6D592B7A3246 FOREIGN KEY (market_product_id) REFERENCES market_product (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE scraper_check ADD CONSTRAINT FK_DBC62168622F3F37 FOREIGN KEY (market_id) REFERENCES market (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE prices DROP CONSTRAINT FK_E4CB6D592B7A3246');
        $this->addSql('ALTER TABLE market_product DROP CONSTRAINT FK_DADCEC2D12469DE2');
        $this->addSql('ALTER TABLE market_product DROP CONSTRAINT FK_DADCEC2D4D9AC4D4');
        $this->addSql('ALTER TABLE market_product DROP CONSTRAINT FK_DADCEC2D622F3F37');
        $this->addSql('ALTER TABLE scraper_log DROP CONSTRAINT FK_20D02255622F3F37');
        $this->addSql('ALTER TABLE scraper_check DROP CONSTRAINT FK_DBC62168622F3F37');
        $this->addSql('DROP SEQUENCE market_product_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE category_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE master_product_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE scraper_log_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE prices_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE scraper_check_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE market_id_seq CASCADE');
        $this->addSql('DROP TABLE market_product');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE master_product');
        $this->addSql('DROP TABLE scraper_log');
        $this->addSql('DROP TABLE prices');
        $this->addSql('DROP TABLE scraper_check');
        $this->addSql('DROP TABLE market');
    }
}
