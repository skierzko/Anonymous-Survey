<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260114134100 extends AbstractMigration
{
public function getDescription(): string
    {
        return 'Create survey_question_option table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('
            CREATE TABLE survey_question_option (
                id INT AUTO_INCREMENT NOT NULL,
                survey_question_id INT NOT NULL,

                title VARCHAR(255) NOT NULL,
                visible TINYINT(1) NOT NULL,

                created_at DATETIME NOT NULL,
                updated_at DATETIME NOT NULL,
                deleted_at DATETIME DEFAULT NULL,

                INDEX IDX_SURVEY_QUESTION_OPTION_QUESTION (survey_question_id),
                PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        ');

        $this->addSql('
            ALTER TABLE survey_question_option
            ADD CONSTRAINT FK_SURVEY_QUESTION_OPTION_QUESTION
            FOREIGN KEY (survey_question_id)
            REFERENCES survey_question (id)
            ON DELETE CASCADE
        ');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('
            ALTER TABLE survey_question_option
            DROP FOREIGN KEY FK_SURVEY_QUESTION_OPTION_QUESTION
        ');
        $this->addSql('DROP TABLE survey_question_option');
    }
}
