<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250715174415 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ged_categorie (id SERIAL NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE ged_categorie_item (id SERIAL NOT NULL, cat_id INT DEFAULT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_685D8BDAE6ADA943 ON ged_categorie_item (cat_id)');
        $this->addSql('CREATE TABLE ged_document (id SERIAL NOT NULL, poster_id INT DEFAULT NULL, categorie_id INT DEFAULT NULL, item_categorie_id INT DEFAULT NULL, title VARCHAR(255) DEFAULT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, tags JSON DEFAULT NULL, gsc_path TEXT DEFAULT NULL, mine_type VARCHAR(100) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_CE3006205BB66C05 ON ged_document (poster_id)');
        $this->addSql('CREATE INDEX IDX_CE300620BCF5E72D ON ged_document (categorie_id)');
        $this->addSql('CREATE INDEX IDX_CE30062073AF1AEC ON ged_document (item_categorie_id)');
        $this->addSql('COMMENT ON COLUMN ged_document.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN ged_document.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE ged_document_user (ged_document_id INT NOT NULL, user_id INT NOT NULL, PRIMARY KEY(ged_document_id, user_id))');
        $this->addSql('CREATE INDEX IDX_450EC9DA2E8F1434 ON ged_document_user (ged_document_id)');
        $this->addSql('CREATE INDEX IDX_450EC9DAA76ED395 ON ged_document_user (user_id)');
        $this->addSql('CREATE TABLE "user" (id SERIAL NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, is_verified BOOLEAN NOT NULL, civilite VARCHAR(30) DEFAULT NULL, prenom VARCHAR(150) DEFAULT NULL, nom VARCHAR(50) DEFAULT NULL, naissance_at DATE DEFAULT NULL, avatar TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL ON "user" (email)');
        $this->addSql('ALTER TABLE ged_categorie_item ADD CONSTRAINT FK_685D8BDAE6ADA943 FOREIGN KEY (cat_id) REFERENCES ged_categorie (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE ged_document ADD CONSTRAINT FK_CE3006205BB66C05 FOREIGN KEY (poster_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE ged_document ADD CONSTRAINT FK_CE300620BCF5E72D FOREIGN KEY (categorie_id) REFERENCES ged_categorie (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE ged_document ADD CONSTRAINT FK_CE30062073AF1AEC FOREIGN KEY (item_categorie_id) REFERENCES ged_categorie_item (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE ged_document_user ADD CONSTRAINT FK_450EC9DA2E8F1434 FOREIGN KEY (ged_document_id) REFERENCES ged_document (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE ged_document_user ADD CONSTRAINT FK_450EC9DAA76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE ged_categorie_item DROP CONSTRAINT FK_685D8BDAE6ADA943');
        $this->addSql('ALTER TABLE ged_document DROP CONSTRAINT FK_CE3006205BB66C05');
        $this->addSql('ALTER TABLE ged_document DROP CONSTRAINT FK_CE300620BCF5E72D');
        $this->addSql('ALTER TABLE ged_document DROP CONSTRAINT FK_CE30062073AF1AEC');
        $this->addSql('ALTER TABLE ged_document_user DROP CONSTRAINT FK_450EC9DA2E8F1434');
        $this->addSql('ALTER TABLE ged_document_user DROP CONSTRAINT FK_450EC9DAA76ED395');
        $this->addSql('DROP TABLE ged_categorie');
        $this->addSql('DROP TABLE ged_categorie_item');
        $this->addSql('DROP TABLE ged_document');
        $this->addSql('DROP TABLE ged_document_user');
        $this->addSql('DROP TABLE "user"');
    }
}
