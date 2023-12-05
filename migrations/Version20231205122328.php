<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231205122328 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE participants_trainings (participants_id INT NOT NULL, trainings_id INT NOT NULL, INDEX IDX_9B061923838709D5 (participants_id), INDEX IDX_9B061923161BA2FF (trainings_id), PRIMARY KEY(participants_id, trainings_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE participants_trainings ADD CONSTRAINT FK_9B061923838709D5 FOREIGN KEY (participants_id) REFERENCES participants (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE participants_trainings ADD CONSTRAINT FK_9B061923161BA2FF FOREIGN KEY (trainings_id) REFERENCES trainings (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE participants_trainings DROP FOREIGN KEY FK_9B061923838709D5');
        $this->addSql('ALTER TABLE participants_trainings DROP FOREIGN KEY FK_9B061923161BA2FF');
        $this->addSql('DROP TABLE participants_trainings');
    }
}
