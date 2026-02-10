<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260210CreateSurveySchema extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create surveys, survey_questions, survey_question_options, and survey_results tables';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE surveys (
            id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
            user_id INTEGER DEFAULT NULL,
            title VARCHAR(255) NOT NULL,
            draft BOOLEAN NOT NULL,
            slug VARCHAR(255) NOT NULL,
            password_required BOOLEAN NOT NULL,
            password VARCHAR(255) DEFAULT NULL,
            extra_options CLOB NOT NULL,
            is_public TINYINT(1) NOT NULL DEFAULT 0,
            public_at DATETIME DEFAULT NULL,
            created_at DATETIME NOT NULL,
            updated_at DATETIME NOT NULL,
            deleted_at DATETIME DEFAULT NULL
        )');

        $this->addSql('CREATE TABLE survey_questions (
            id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
            survey_id INTEGER NOT NULL,
            uuid VARCHAR(32) NOT NULL UNIQUE,
            type VARCHAR(50) NOT NULL,
            title VARCHAR(255) NOT NULL,
            visible BOOLEAN NOT NULL,
            min_options_limit INTEGER NOT NULL,
            max_options_limit INTEGER NOT NULL,
            draft BOOLEAN NOT NULL,
            required BOOLEAN NOT NULL,
            optional BOOLEAN NOT NULL,
            position INTEGER NOT NULL,
            extra_options CLOB NOT NULL,
            created_at DATETIME NOT NULL,
            updated_at DATETIME NOT NULL,
            deleted_at DATETIME DEFAULT NULL,
            CONSTRAINT FK_2F8A16F8B3FE509D FOREIGN KEY (survey_id) REFERENCES surveys (id)
        )');

        $this->addSql('CREATE TABLE survey_question_options (
            id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
            question_id INTEGER NOT NULL,
            uuid VARCHAR(32) NOT NULL UNIQUE,
            title VARCHAR(255) NOT NULL,
            visible BOOLEAN NOT NULL,
            position INTEGER NOT NULL,
            created_at DATETIME NOT NULL,
            updated_at DATETIME NOT NULL,
            deleted_at DATETIME DEFAULT NULL,
            CONSTRAINT FK_FFF50FFD1E27F6BF FOREIGN KEY (question_id) REFERENCES survey_questions (id)
        )');

        $this->addSql('CREATE TABLE survey_results (
            id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
            survey_id INTEGER NOT NULL,
            results TEXT NOT NULL,
            created_at DATETIME NOT NULL,
            updated_at DATETIME NOT NULL,
            deleted_at DATETIME DEFAULT NULL,
            FOREIGN KEY (survey_id) REFERENCES surveys (id)
        )');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE IF EXISTS survey_results');
        $this->addSql('DROP TABLE IF EXISTS survey_question_options');
        $this->addSql('DROP TABLE IF EXISTS survey_questions');
        $this->addSql('DROP TABLE IF EXISTS surveys');
    }
}
