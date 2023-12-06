<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231206104633 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F1496545BB827337 ON programs (year)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F14965454F07AA14 ON programs (file_src)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_F1496545BB827337 ON programs');
        $this->addSql('DROP INDEX UNIQ_F14965454F07AA14 ON programs');
    }
}
