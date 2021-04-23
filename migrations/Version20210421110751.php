<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210421110751 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reponse_d ADD CONSTRAINT FK_D3F517C96F1A5C10 FOREIGN KEY (specialiste_id) REFERENCES specialiste (id)');
        $this->addSql('CREATE INDEX IDX_D3F517C96F1A5C10 ON reponse_d (specialiste_id)');
        $this->addSql('ALTER TABLE specialiste ADD dossier LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', ADD rpps INT NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reponse_d DROP FOREIGN KEY FK_D3F517C96F1A5C10');
        $this->addSql('DROP INDEX IDX_D3F517C96F1A5C10 ON reponse_d');
        $this->addSql('ALTER TABLE specialiste DROP dossier, DROP rpps');
    }
}
