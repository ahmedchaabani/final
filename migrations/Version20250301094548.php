<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250301094548 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE analyse (idanalyse INT AUTO_INCREMENT NOT NULL, id_e INT DEFAULT NULL, id_user INT DEFAULT NULL, type_e VARCHAR(255) NOT NULL, result VARCHAR(255) NOT NULL, date_performed DATE NOT NULL, INDEX IDX_351B0C7E284FD025 (id_e), INDEX IDX_351B0C7E6B3CA4B (id_user), PRIMARY KEY(idanalyse)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE animal (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, age INT NOT NULL, type VARCHAR(255) NOT NULL, espece VARCHAR(255) NOT NULL, traitement VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE echantillon (id_e INT AUTO_INCREMENT NOT NULL, code_x VARCHAR(255) NOT NULL, type_e VARCHAR(255) NOT NULL, collection_date DATE NOT NULL, origin VARCHAR(255) NOT NULL, status VARCHAR(255) NOT NULL, PRIMARY KEY(id_e)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fournisseur (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, telephone VARCHAR(255) NOT NULL, lieu VARCHAR(255) NOT NULL, date_enregistrement DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE produit (id INT AUTO_INCREMENT NOT NULL, fournisseur_id INT NOT NULL, id_user INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, prix DOUBLE PRECISION NOT NULL, quantite_stock DOUBLE PRECISION NOT NULL, date_ajout DATE NOT NULL, categorie VARCHAR(255) NOT NULL, INDEX IDX_29A5EC27670C757F (fournisseur_id), INDEX IDX_29A5EC276B3CA4B (id_user), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, telephone VARCHAR(15) DEFAULT NULL, adresse VARCHAR(255) DEFAULT NULL, date_inscription DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, is_verified TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE veterinaire (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, specialite VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, telephone VARCHAR(255) NOT NULL, disponibilite VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE visite (id INT AUTO_INCREMENT NOT NULL, animal_id INT NOT NULL, veterinaire_id INT NOT NULL, id_user INT DEFAULT NULL, date_visite DATETIME NOT NULL, diagnostic VARCHAR(255) NOT NULL, INDEX IDX_B09C8CBB8E962C16 (animal_id), INDEX IDX_B09C8CBB5C80924 (veterinaire_id), INDEX IDX_B09C8CBB6B3CA4B (id_user), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE analyse ADD CONSTRAINT FK_351B0C7E284FD025 FOREIGN KEY (id_e) REFERENCES echantillon (id_e) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE analyse ADD CONSTRAINT FK_351B0C7E6B3CA4B FOREIGN KEY (id_user) REFERENCES user (id)');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC27670C757F FOREIGN KEY (fournisseur_id) REFERENCES fournisseur (id)');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC276B3CA4B FOREIGN KEY (id_user) REFERENCES user (id)');
        $this->addSql('ALTER TABLE visite ADD CONSTRAINT FK_B09C8CBB8E962C16 FOREIGN KEY (animal_id) REFERENCES animal (id)');
        $this->addSql('ALTER TABLE visite ADD CONSTRAINT FK_B09C8CBB5C80924 FOREIGN KEY (veterinaire_id) REFERENCES veterinaire (id)');
        $this->addSql('ALTER TABLE visite ADD CONSTRAINT FK_B09C8CBB6B3CA4B FOREIGN KEY (id_user) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE analyse DROP FOREIGN KEY FK_351B0C7E284FD025');
        $this->addSql('ALTER TABLE analyse DROP FOREIGN KEY FK_351B0C7E6B3CA4B');
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC27670C757F');
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC276B3CA4B');
        $this->addSql('ALTER TABLE visite DROP FOREIGN KEY FK_B09C8CBB8E962C16');
        $this->addSql('ALTER TABLE visite DROP FOREIGN KEY FK_B09C8CBB5C80924');
        $this->addSql('ALTER TABLE visite DROP FOREIGN KEY FK_B09C8CBB6B3CA4B');
        $this->addSql('DROP TABLE analyse');
        $this->addSql('DROP TABLE animal');
        $this->addSql('DROP TABLE echantillon');
        $this->addSql('DROP TABLE fournisseur');
        $this->addSql('DROP TABLE produit');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE veterinaire');
        $this->addSql('DROP TABLE visite');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
