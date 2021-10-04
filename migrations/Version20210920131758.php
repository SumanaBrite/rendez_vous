<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210920131758 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article_fast_food_menu DROP FOREIGN KEY FK_ABE11B577294869C');
        $this->addSql('ALTER TABLE article_boucherie DROP FOREIGN KEY FK_C7A1F7DBCF5E72D');
        $this->addSql('ALTER TABLE article_fast_food DROP FOREIGN KEY FK_D083711BCF5E72D');
        $this->addSql('ALTER TABLE article_boucherie DROP FOREIGN KEY FK_C7A1F7DF8BD700D');
        $this->addSql('ALTER TABLE article_fast_food_menu DROP FOREIGN KEY FK_ABE11B57CCD7E912');
        $this->addSql('ALTER TABLE article_boucherie DROP FOREIGN KEY FK_C7A1F7D4D79775F');
        $this->addSql('ALTER TABLE article_fast_food DROP FOREIGN KEY FK_D0837114D79775F');
        $this->addSql('ALTER TABLE article_fast_food DROP FOREIGN KEY FK_D083711F8BD700D');
        $this->addSql('DROP TABLE article_boucherie');
        $this->addSql('DROP TABLE article_fast_food');
        $this->addSql('DROP TABLE article_fast_food_menu');
        $this->addSql('DROP TABLE categorie_boucherie');
        $this->addSql('DROP TABLE categorie_fast_food');
        $this->addSql('DROP TABLE event');
        $this->addSql('DROP TABLE measure');
        $this->addSql('DROP TABLE menu_fast_food');
        $this->addSql('DROP TABLE taux_tva');
        $this->addSql('DROP TABLE unite_fast_food');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE article_boucherie (id INT AUTO_INCREMENT NOT NULL, unit_id INT NOT NULL, categorie_id INT NOT NULL, tva_id INT NOT NULL, nom VARCHAR(70) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, description VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, prix_unitaire NUMERIC(10, 2) NOT NULL, path VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, image VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, promotion TINYINT(1) DEFAULT NULL, prix_promotion NUMERIC(10, 2) DEFAULT NULL, INDEX IDX_C7A1F7D4D79775F (tva_id), INDEX IDX_C7A1F7DF8BD700D (unit_id), INDEX IDX_C7A1F7DBCF5E72D (categorie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE article_fast_food (id INT AUTO_INCREMENT NOT NULL, unit_id INT NOT NULL, categorie_id INT NOT NULL, tva_id INT NOT NULL, nom VARCHAR(60) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, description VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, prix_unitaire NUMERIC(10, 2) NOT NULL, path VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, image VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, promotion TINYINT(1) DEFAULT NULL, prix_promotion NUMERIC(10, 2) DEFAULT NULL, INDEX IDX_D0837114D79775F (tva_id), INDEX IDX_D083711F8BD700D (unit_id), INDEX IDX_D083711BCF5E72D (categorie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE article_fast_food_menu (id INT AUTO_INCREMENT NOT NULL, menu_id INT NOT NULL, article_id INT NOT NULL, INDEX IDX_ABE11B57CCD7E912 (menu_id), INDEX IDX_ABE11B577294869C (article_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE categorie_boucherie (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(60) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE categorie_fast_food (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(40) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE event (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, description VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, date DATE NOT NULL, image VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, path VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE measure (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(60) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE menu_fast_food (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(60) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, description VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, prit_unitaire INT NOT NULL, image VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, path VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, promotion TINYINT(1) DEFAULT NULL, prix_promotion INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE taux_tva (id INT AUTO_INCREMENT NOT NULL, taux INT NOT NULL, description VARCHAR(30) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE unite_fast_food (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(40) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE article_boucherie ADD CONSTRAINT FK_C7A1F7D4D79775F FOREIGN KEY (tva_id) REFERENCES taux_tva (id)');
        $this->addSql('ALTER TABLE article_boucherie ADD CONSTRAINT FK_C7A1F7DBCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie_boucherie (id)');
        $this->addSql('ALTER TABLE article_boucherie ADD CONSTRAINT FK_C7A1F7DF8BD700D FOREIGN KEY (unit_id) REFERENCES measure (id)');
        $this->addSql('ALTER TABLE article_fast_food ADD CONSTRAINT FK_D0837114D79775F FOREIGN KEY (tva_id) REFERENCES taux_tva (id)');
        $this->addSql('ALTER TABLE article_fast_food ADD CONSTRAINT FK_D083711BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie_fast_food (id)');
        $this->addSql('ALTER TABLE article_fast_food ADD CONSTRAINT FK_D083711F8BD700D FOREIGN KEY (unit_id) REFERENCES unite_fast_food (id)');
        $this->addSql('ALTER TABLE article_fast_food_menu ADD CONSTRAINT FK_ABE11B577294869C FOREIGN KEY (article_id) REFERENCES article_fast_food (id)');
        $this->addSql('ALTER TABLE article_fast_food_menu ADD CONSTRAINT FK_ABE11B57CCD7E912 FOREIGN KEY (menu_id) REFERENCES menu_fast_food (id)');
    }
}
