<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211211024641 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, full_name VARCHAR(255) NOT NULL, phone_number VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, monthly_income NUMERIC(10, 2) NOT NULL, profession VARCHAR(255) NOT NULL, gender VARCHAR(50) NOT NULL, balance NUMERIC(10, 2) NOT NULL, address LONGTEXT NOT NULL, birthdate DATETIME NOT NULL, id_doc_number VARCHAR(255) NOT NULL, id_picture_url VARCHAR(255) NOT NULL, id_doc_picture_url VARCHAR(255) NOT NULL, is_team_lead TINYINT(1) NOT NULL, extra JSON DEFAULT NULL, nationality VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_C7440455B17D822F (id_doc_number), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE note (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, project_id INT NOT NULL, content LONGTEXT NOT NULL, user_role_translate VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_CFBDFA14A76ED395 (user_id), INDEX IDX_CFBDFA14166D1F9C (project_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE payment_details (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, project_master_id INT DEFAULT NULL, type TINYINT(1) NOT NULL, amount NUMERIC(10, 2) NOT NULL, amount_to_send NUMERIC(10, 2) DEFAULT NULL, amount_to_receive NUMERIC(10, 2) DEFAULT NULL, extra JSON DEFAULT NULL, payment_detail_doc VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_6B6F0560A76ED395 (user_id), INDEX IDX_6B6F056028F9EC6 (project_master_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE project (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, amount NUMERIC(10, 2) NOT NULL, final_amount NUMERIC(10, 2) DEFAULT NULL, repayment_duration NUMERIC(10, 2) NOT NULL, modality_amount NUMERIC(10, 2) NOT NULL, status VARCHAR(255) NOT NULL, modality_payment_frequency INT NOT NULL, details LONGTEXT NOT NULL, extra JSON DEFAULT NULL, business_plan_doc_url VARCHAR(255) NOT NULL, details_extra_doc_url VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE project_master (id INT AUTO_INCREMENT NOT NULL, project_id INT DEFAULT NULL, end_date DATETIME DEFAULT NULL, is_abandoned TINYINT(1) NOT NULL, evaluation INT DEFAULT NULL, team_lead_doc_id VARCHAR(255) NOT NULL, request_id VARCHAR(255) NOT NULL, is_finished TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_3AAD489C427EB8A5 (request_id), UNIQUE INDEX UNIQ_3AAD489C166D1F9C (project_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE project_master_client (project_master_id INT NOT NULL, client_id INT NOT NULL, INDEX IDX_E235347D28F9EC6 (project_master_id), INDEX IDX_E235347D19EB6921 (client_id), PRIMARY KEY(project_master_id, client_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE saving_details (id INT AUTO_INCREMENT NOT NULL, client_id INT NOT NULL, user_id INT NOT NULL, type TINYINT(1) NOT NULL, amount NUMERIC(10, 2) NOT NULL, paid_month INT NOT NULL, detail_doc_url VARCHAR(255) NOT NULL, extra JSON DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_E05E8D1B19EB6921 (client_id), INDEX IDX_E05E8D1BA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, full_name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, is_active TINYINT(1) NOT NULL, last_login DATETIME DEFAULT NULL, birthdate DATETIME NOT NULL, nationality VARCHAR(255) NOT NULL, phone_number VARCHAR(255) NOT NULL, address LONGTEXT DEFAULT NULL, gender VARCHAR(30) NOT NULL, id_doc_number VARCHAR(255) NOT NULL, id_doc_url VARCHAR(255) DEFAULT NULL, photo_url VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_1483A5E9F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA14A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA14166D1F9C FOREIGN KEY (project_id) REFERENCES project (id)');
        $this->addSql('ALTER TABLE payment_details ADD CONSTRAINT FK_6B6F0560A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE payment_details ADD CONSTRAINT FK_6B6F056028F9EC6 FOREIGN KEY (project_master_id) REFERENCES project_master (id)');
        $this->addSql('ALTER TABLE project_master ADD CONSTRAINT FK_3AAD489C166D1F9C FOREIGN KEY (project_id) REFERENCES project (id)');
        $this->addSql('ALTER TABLE project_master_client ADD CONSTRAINT FK_E235347D28F9EC6 FOREIGN KEY (project_master_id) REFERENCES project_master (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE project_master_client ADD CONSTRAINT FK_E235347D19EB6921 FOREIGN KEY (client_id) REFERENCES client (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE saving_details ADD CONSTRAINT FK_E05E8D1B19EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE saving_details ADD CONSTRAINT FK_E05E8D1BA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE project_master_client DROP FOREIGN KEY FK_E235347D19EB6921');
        $this->addSql('ALTER TABLE saving_details DROP FOREIGN KEY FK_E05E8D1B19EB6921');
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA14166D1F9C');
        $this->addSql('ALTER TABLE project_master DROP FOREIGN KEY FK_3AAD489C166D1F9C');
        $this->addSql('ALTER TABLE payment_details DROP FOREIGN KEY FK_6B6F056028F9EC6');
        $this->addSql('ALTER TABLE project_master_client DROP FOREIGN KEY FK_E235347D28F9EC6');
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA14A76ED395');
        $this->addSql('ALTER TABLE payment_details DROP FOREIGN KEY FK_6B6F0560A76ED395');
        $this->addSql('ALTER TABLE saving_details DROP FOREIGN KEY FK_E05E8D1BA76ED395');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE note');
        $this->addSql('DROP TABLE payment_details');
        $this->addSql('DROP TABLE project');
        $this->addSql('DROP TABLE project_master');
        $this->addSql('DROP TABLE project_master_client');
        $this->addSql('DROP TABLE saving_details');
        $this->addSql('DROP TABLE users');
    }
}
