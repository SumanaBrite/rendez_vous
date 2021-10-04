<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210923142451 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE rdv DROP FOREIGN KEY FK_10C31F86A832C1C9');
        $this->addSql('DROP INDEX IDX_10C31F86A832C1C9 ON rdv');
        $this->addSql('ALTER TABLE rdv ADD email VARCHAR(255) NOT NULL, ADD prenom VARCHAR(40) NOT NULL, ADD nom VARCHAR(50) NOT NULL, DROP email_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE rdv ADD email_id INT NOT NULL, DROP email, DROP prenom, DROP nom');
        $this->addSql('ALTER TABLE rdv ADD CONSTRAINT FK_10C31F86A832C1C9 FOREIGN KEY (email_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_10C31F86A832C1C9 ON rdv (email_id)');
    }
}
