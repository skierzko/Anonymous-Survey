<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260114134036 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create survey_question table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('
            CREATE TABLE survey_question (
                id INT AUTO_INCREMENT NOT NULL,
                survey_id INT NOT NULL,

                type VARCHAR(50) NOT NULL,
                title VARCHAR(255) NOT NULL,
                visible TINYINT(1) NOT NULL,
                min_options_limit INT NOT NULL,
                max_options_limit INT NOT NULL,
                draft TINYINT(1) NOT NULL,
                required TINYINT(1) NOT NULL,
                optional TINYINT(1) NOT NULL,

                created_at DATETIME NOT NULL,
                updated_at DATETIME NOT NULL,
                deleted_at DATETIME DEFAULT NULL,

                INDEX IDX_SURVEY_QUESTION_SURVEY (survey_id),
                PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        ');

        $this->addSql('
            ALTER TABLE survey_question
            ADD CONSTRAINT FK_SURVEY_QUESTION_SURVEY
            FOREIGN KEY (survey_id) REFERENCES survey (id)
            ON DELETE CASCADE
        ');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE survey_question DROP FOREIGN KEY FK_SURVEY_QUESTION_SURVEY');
        $this->addSql('DROP TABLE survey_question');
    }
}
