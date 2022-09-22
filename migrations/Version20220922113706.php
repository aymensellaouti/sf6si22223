<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220922113706 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE club (id INT AUTO_INCREMENT NOT NULL, designation VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cours (id INT AUTO_INCREMENT NOT NULL, designation VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE personne_cours (personne_id INT NOT NULL, cours_id INT NOT NULL, INDEX IDX_E92B9DF5A21BD112 (personne_id), INDEX IDX_E92B9DF57ECF78B0 (cours_id), PRIMARY KEY(personne_id, cours_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE profil (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE personne_cours ADD CONSTRAINT FK_E92B9DF5A21BD112 FOREIGN KEY (personne_id) REFERENCES personne (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE personne_cours ADD CONSTRAINT FK_E92B9DF57ECF78B0 FOREIGN KEY (cours_id) REFERENCES cours (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE personne ADD club_id INT DEFAULT NULL, ADD profil_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE personne ADD CONSTRAINT FK_FCEC9EF61190A32 FOREIGN KEY (club_id) REFERENCES club (id)');
        $this->addSql('ALTER TABLE personne ADD CONSTRAINT FK_FCEC9EF275ED078 FOREIGN KEY (profil_id) REFERENCES profil (id)');
        $this->addSql('CREATE INDEX IDX_FCEC9EF61190A32 ON personne (club_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_FCEC9EF275ED078 ON personne (profil_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE personne DROP FOREIGN KEY FK_FCEC9EF61190A32');
        $this->addSql('ALTER TABLE personne DROP FOREIGN KEY FK_FCEC9EF275ED078');
        $this->addSql('ALTER TABLE personne_cours DROP FOREIGN KEY FK_E92B9DF5A21BD112');
        $this->addSql('ALTER TABLE personne_cours DROP FOREIGN KEY FK_E92B9DF57ECF78B0');
        $this->addSql('DROP TABLE club');
        $this->addSql('DROP TABLE cours');
        $this->addSql('DROP TABLE personne_cours');
        $this->addSql('DROP TABLE profil');
        $this->addSql('DROP INDEX IDX_FCEC9EF61190A32 ON personne');
        $this->addSql('DROP INDEX UNIQ_FCEC9EF275ED078 ON personne');
        $this->addSql('ALTER TABLE personne DROP club_id, DROP profil_id');
    }
}
