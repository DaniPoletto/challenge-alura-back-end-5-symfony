<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221103224457 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE video ADD id_categoria_id INT NOT NULL');
        $this->addSql('ALTER TABLE video ADD CONSTRAINT FK_7CC7DA2C10560508 FOREIGN KEY (id_categoria_id) REFERENCES categoria (id)');
        $this->addSql('CREATE INDEX IDX_7CC7DA2C10560508 ON video (id_categoria_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE video DROP FOREIGN KEY FK_7CC7DA2C10560508');
        $this->addSql('DROP INDEX IDX_7CC7DA2C10560508 ON video');
        $this->addSql('ALTER TABLE video DROP id_categoria_id');
    }
}
