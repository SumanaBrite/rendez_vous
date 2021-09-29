<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210926161320 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE compte_jour (id INT AUTO_INCREMENT NOT NULL, date DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contact (id INT AUTO_INCREMENT NOT NULL, prenom VARCHAR(70) NOT NULL, nom VARCHAR(70) NOT NULL, email VARCHAR(255) NOT NULL, message LONGTEXT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', is_send TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE creneau (id INT AUTO_INCREMENT NOT NULL, description VARCHAR(20) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE guichet (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(20) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE horaire (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(20) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE horaire_fermeture_guichet (id INT AUTO_INCREMENT NOT NULL, guichet_id INT NOT NULL, horaire_id INT NOT NULL, jour DATE NOT NULL, INDEX IDX_D046E82DD75742EE (guichet_id), INDEX IDX_D046E82D58C54515 (horaire_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE jour_fermeture_guichet (id INT AUTO_INCREMENT NOT NULL, guichet_id INT NOT NULL, jour DATE NOT NULL, INDEX IDX_A842C68FD75742EE (guichet_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE money_transfert (id INT AUTO_INCREMENT NOT NULL, ria DOUBLE PRECISION NOT NULL, money_gram DOUBLE PRECISION NOT NULL, western_union DOUBLE PRECISION NOT NULL, path VARCHAR(255) NOT NULL, pays VARCHAR(70) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rdv (id INT AUTO_INCREMENT NOT NULL, guichet_id INT NOT NULL, creneau_id INT NOT NULL, horaire_id INT NOT NULL, jour DATE NOT NULL, email VARCHAR(255) NOT NULL, prenom VARCHAR(40) NOT NULL, nom VARCHAR(50) NOT NULL, INDEX IDX_10C31F86D75742EE (guichet_id), INDEX IDX_10C31F867D0729A9 (creneau_id), INDEX IDX_10C31F8658C54515 (horaire_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reset_password_request (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, selector VARCHAR(20) NOT NULL, hashed_token VARCHAR(100) NOT NULL, requested_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', expires_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_7CE748AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, nom VARCHAR(60) NOT NULL, prenom VARCHAR(60) NOT NULL, telephone VARCHAR(20) DEFAULT NULL, no_rue VARCHAR(10) NOT NULL, rue VARCHAR(255) NOT NULL, code_postale VARCHAR(10) NOT NULL, ville VARCHAR(255) NOT NULL, is_verified TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE horaire_fermeture_guichet ADD CONSTRAINT FK_D046E82DD75742EE FOREIGN KEY (guichet_id) REFERENCES guichet (id)');
        $this->addSql('ALTER TABLE horaire_fermeture_guichet ADD CONSTRAINT FK_D046E82D58C54515 FOREIGN KEY (horaire_id) REFERENCES horaire (id)');
        $this->addSql('ALTER TABLE jour_fermeture_guichet ADD CONSTRAINT FK_A842C68FD75742EE FOREIGN KEY (guichet_id) REFERENCES guichet (id)');
        $this->addSql('ALTER TABLE rdv ADD CONSTRAINT FK_10C31F86D75742EE FOREIGN KEY (guichet_id) REFERENCES guichet (id)');
        $this->addSql('ALTER TABLE rdv ADD CONSTRAINT FK_10C31F867D0729A9 FOREIGN KEY (creneau_id) REFERENCES creneau (id)');
        $this->addSql('ALTER TABLE rdv ADD CONSTRAINT FK_10C31F8658C54515 FOREIGN KEY (horaire_id) REFERENCES horaire (id)');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE rdv DROP FOREIGN KEY FK_10C31F867D0729A9');
        $this->addSql('ALTER TABLE horaire_fermeture_guichet DROP FOREIGN KEY FK_D046E82DD75742EE');
        $this->addSql('ALTER TABLE jour_fermeture_guichet DROP FOREIGN KEY FK_A842C68FD75742EE');
        $this->addSql('ALTER TABLE rdv DROP FOREIGN KEY FK_10C31F86D75742EE');
        $this->addSql('ALTER TABLE horaire_fermeture_guichet DROP FOREIGN KEY FK_D046E82D58C54515');
        $this->addSql('ALTER TABLE rdv DROP FOREIGN KEY FK_10C31F8658C54515');
        $this->addSql('ALTER TABLE reset_password_request DROP FOREIGN KEY FK_7CE748AA76ED395');
        $this->addSql('DROP TABLE compte_jour');
        $this->addSql('DROP TABLE contact');
        $this->addSql('DROP TABLE creneau');
        $this->addSql('DROP TABLE guichet');
        $this->addSql('DROP TABLE horaire');
        $this->addSql('DROP TABLE horaire_fermeture_guichet');
        $this->addSql('DROP TABLE jour_fermeture_guichet');
        $this->addSql('DROP TABLE money_transfert');
        $this->addSql('DROP TABLE rdv');
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('DROP TABLE user');
    }
}
