<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210112023735 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA shop');
        $this->addSql('CREATE SEQUENCE shop.item_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE shop.person_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE shop.phone_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE shop.ship_order_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE shop.ship_to_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE shop.user_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE shop.item (id INT NOT NULL, ship_order_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, note VARCHAR(255) NOT NULL, quantity INT NOT NULL, price NUMERIC(5, 2) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_1A5B0A1ABE925DED ON shop.item (ship_order_id)');
        $this->addSql('CREATE TABLE shop.person (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE shop.phone (id INT NOT NULL, person_id INT DEFAULT NULL, number VARCHAR(15) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_432713EB217BBB47 ON shop.phone (person_id)');
        $this->addSql('CREATE TABLE shop.ship_order (id INT NOT NULL, person_id INT NOT NULL, ship_to_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B18FA058217BBB47 ON shop.ship_order (person_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B18FA058314C19B0 ON shop.ship_order (ship_to_id)');
        $this->addSql('CREATE TABLE shop.ship_to (id INT NOT NULL, name VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, country VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE shop."user" (id INT NOT NULL, username VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_88D3F94DF85E0677 ON shop."user" (username)');
        $this->addSql('ALTER TABLE shop.item ADD CONSTRAINT FK_1A5B0A1ABE925DED FOREIGN KEY (ship_order_id) REFERENCES shop.ship_order (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE shop.phone ADD CONSTRAINT FK_432713EB217BBB47 FOREIGN KEY (person_id) REFERENCES shop.person (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE shop.ship_order ADD CONSTRAINT FK_B18FA058217BBB47 FOREIGN KEY (person_id) REFERENCES shop.person (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE shop.ship_order ADD CONSTRAINT FK_B18FA058314C19B0 FOREIGN KEY (ship_to_id) REFERENCES shop.ship_to (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE shop.phone DROP CONSTRAINT FK_432713EB217BBB47');
        $this->addSql('ALTER TABLE shop.ship_order DROP CONSTRAINT FK_B18FA058217BBB47');
        $this->addSql('ALTER TABLE shop.item DROP CONSTRAINT FK_1A5B0A1ABE925DED');
        $this->addSql('ALTER TABLE shop.ship_order DROP CONSTRAINT FK_B18FA058314C19B0');
        $this->addSql('DROP SEQUENCE shop.item_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE shop.person_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE shop.phone_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE shop.ship_order_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE shop.ship_to_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE shop.user_id_seq CASCADE');
        $this->addSql('DROP TABLE shop.item');
        $this->addSql('DROP TABLE shop.person');
        $this->addSql('DROP TABLE shop.phone');
        $this->addSql('DROP TABLE shop.ship_order');
        $this->addSql('DROP TABLE shop.ship_to');
        $this->addSql('DROP TABLE shop."user"');
    }
}
