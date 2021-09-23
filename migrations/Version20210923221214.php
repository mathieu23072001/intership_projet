<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210923221214 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE candidature CHANGE offre_id offre_id INT DEFAULT NULL, CHANGE etudiant_id etudiant_id INT DEFAULT NULL, CHANGE active active TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE entreprise CHANGE user_id user_id INT DEFAULT NULL, CHANGE update_at update_at DATETIME DEFAULT NULL, CHANGE image image VARCHAR(255) DEFAULT NULL, CHANGE creat_at creat_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE etudiant CHANGE user_id user_id INT DEFAULT NULL, CHANGE specialite_id specialite_id INT DEFAULT NULL, CHANGE niveau_id niveau_id INT DEFAULT NULL, CHANGE entreprise_id entreprise_id INT DEFAULT NULL, CHANGE update_at update_at DATETIME DEFAULT NULL, CHANGE image image VARCHAR(255) DEFAULT NULL, CHANGE creat_at creat_at DATETIME DEFAULT NULL, CHANGE date_debut date_debut DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE niveau CHANGE nom nom VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE offre CHANGE entreprise_id entreprise_id INT DEFAULT NULL, CHANGE specialite_id specialite_id INT DEFAULT NULL, CHANGE titre titre VARCHAR(255) DEFAULT NULL, CHANGE creat_at creat_at DATETIME DEFAULT NULL, CHANGE langage langage VARCHAR(255) DEFAULT NULL, CHANGE active active TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE specialite CHANGE nom nom VARCHAR(255) DEFAULT NULL, CHANGE color color VARCHAR(7) DEFAULT NULL');
        $this->addSql('ALTER TABLE upload CHANGE etudiant_id etudiant_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL, CHANGE activation_token activation_token VARCHAR(50) DEFAULT NULL, CHANGE count count INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE candidature CHANGE offre_id offre_id INT DEFAULT NULL, CHANGE etudiant_id etudiant_id INT DEFAULT NULL, CHANGE active active TINYINT(1) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE entreprise CHANGE user_id user_id INT DEFAULT NULL, CHANGE update_at update_at DATETIME DEFAULT \'NULL\', CHANGE image image VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE creat_at creat_at DATETIME DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE etudiant CHANGE user_id user_id INT DEFAULT NULL, CHANGE specialite_id specialite_id INT DEFAULT NULL, CHANGE niveau_id niveau_id INT DEFAULT NULL, CHANGE entreprise_id entreprise_id INT DEFAULT NULL, CHANGE update_at update_at DATETIME DEFAULT \'NULL\', CHANGE image image VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE creat_at creat_at DATETIME DEFAULT \'NULL\', CHANGE date_debut date_debut DATETIME DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE niveau CHANGE nom nom VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE offre CHANGE entreprise_id entreprise_id INT DEFAULT NULL, CHANGE specialite_id specialite_id INT DEFAULT NULL, CHANGE titre titre VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE creat_at creat_at DATETIME DEFAULT \'NULL\', CHANGE langage langage VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE active active TINYINT(1) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE specialite CHANGE nom nom VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE color color VARCHAR(7) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE upload CHANGE etudiant_id etudiant_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_bin`, CHANGE activation_token activation_token VARCHAR(50) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE count count INT DEFAULT NULL');
    }
}
