<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230317162809 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reglement ADD id_bateaux_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reglement ADD CONSTRAINT FK_EBE4C14CEC8F7232 FOREIGN KEY (id_bateaux_id) REFERENCES bateaux (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_EBE4C14CEC8F7232 ON reglement (id_bateaux_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reglement DROP FOREIGN KEY FK_EBE4C14CEC8F7232');
        $this->addSql('DROP INDEX UNIQ_EBE4C14CEC8F7232 ON reglement');
        $this->addSql('ALTER TABLE reglement DROP id_bateaux_id');
    }
}
