<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260206172145 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__survey_question_options AS SELECT id, question_id, uuid, title, visible, position, created_at, updated_at, deleted_at FROM survey_question_options');
        $this->addSql('DROP TABLE survey_question_options');
        $this->addSql('CREATE TABLE survey_question_options (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, question_id INTEGER NOT NULL, uuid VARCHAR(36) NOT NULL, title VARCHAR(255) NOT NULL, visible BOOLEAN NOT NULL, position INTEGER NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, CONSTRAINT FK_FFF50FFD1E27F6BF FOREIGN KEY (question_id) REFERENCES survey_questions (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO survey_question_options (id, question_id, uuid, title, visible, position, created_at, updated_at, deleted_at) SELECT id, question_id, uuid, title, visible, position, created_at, updated_at, deleted_at FROM __temp__survey_question_options');
        $this->addSql('DROP TABLE __temp__survey_question_options');
        $this->addSql('CREATE INDEX IDX_FFF50FFD1E27F6BF ON survey_question_options (question_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_FFF50FFDD17F50A6 ON survey_question_options (uuid)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__survey_questions AS SELECT id, survey_id, uuid, type, title, visible, min_options_limit, max_options_limit, draft, required, optional, position, extra_options, created_at, updated_at, deleted_at FROM survey_questions');
        $this->addSql('DROP TABLE survey_questions');
        $this->addSql('CREATE TABLE survey_questions (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, survey_id INTEGER NOT NULL, uuid VARCHAR(36) NOT NULL, type VARCHAR(50) NOT NULL, title VARCHAR(255) NOT NULL, visible BOOLEAN NOT NULL, min_options_limit INTEGER NOT NULL, max_options_limit INTEGER NOT NULL, draft BOOLEAN NOT NULL, required BOOLEAN NOT NULL, optional BOOLEAN NOT NULL, position INTEGER NOT NULL, extra_options CLOB NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, CONSTRAINT FK_2F8A16F8B3FE509D FOREIGN KEY (survey_id) REFERENCES surveys (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO survey_questions (id, survey_id, uuid, type, title, visible, min_options_limit, max_options_limit, draft, required, optional, position, extra_options, created_at, updated_at, deleted_at) SELECT id, survey_id, uuid, type, title, visible, min_options_limit, max_options_limit, draft, required, optional, position, extra_options, created_at, updated_at, deleted_at FROM __temp__survey_questions');
        $this->addSql('DROP TABLE __temp__survey_questions');
        $this->addSql('CREATE INDEX IDX_2F8A16F8B3FE509D ON survey_questions (survey_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2F8A16F8D17F50A6 ON survey_questions (uuid)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__surveys AS SELECT id, user_id, title, draft, slug, password_required, password, extra_options, is_public, public_at, created_at, updated_at, deleted_at FROM surveys');
        $this->addSql('DROP TABLE surveys');
        $this->addSql('CREATE TABLE surveys (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER DEFAULT NULL, title VARCHAR(255) NOT NULL, draft BOOLEAN NOT NULL, slug VARCHAR(255) NOT NULL, password_required BOOLEAN NOT NULL, password VARCHAR(255) DEFAULT NULL, extra_options CLOB NOT NULL, is_public BOOLEAN NOT NULL, public_at DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, uuid VARCHAR(36) NOT NULL)');
        $this->addSql('INSERT INTO surveys (id, user_id, title, draft, slug, password_required, password, extra_options, is_public, public_at, created_at, updated_at, deleted_at) SELECT id, user_id, title, draft, slug, password_required, password, extra_options, is_public, public_at, created_at, updated_at, deleted_at FROM __temp__surveys');
        $this->addSql('DROP TABLE __temp__surveys');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_AFA82EA7989D9B62 ON surveys (slug)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_AFA82EA7D17F50A6 ON surveys (uuid)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__survey_question_options AS SELECT id, uuid, title, visible, position, created_at, updated_at, deleted_at, question_id FROM survey_question_options');
        $this->addSql('DROP TABLE survey_question_options');
        $this->addSql('CREATE TABLE survey_question_options (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, uuid VARCHAR(32) NOT NULL, title VARCHAR(255) NOT NULL, visible BOOLEAN NOT NULL, position INTEGER NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, question_id INTEGER NOT NULL, CONSTRAINT FK_FFF50FFD1E27F6BF FOREIGN KEY (question_id) REFERENCES survey_questions (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO survey_question_options (id, uuid, title, visible, position, created_at, updated_at, deleted_at, question_id) SELECT id, uuid, title, visible, position, created_at, updated_at, deleted_at, question_id FROM __temp__survey_question_options');
        $this->addSql('DROP TABLE __temp__survey_question_options');
        $this->addSql('CREATE INDEX IDX_FFF50FFD1E27F6BF ON survey_question_options (question_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__survey_questions AS SELECT id, uuid, type, title, visible, min_options_limit, max_options_limit, draft, required, optional, position, extra_options, created_at, updated_at, deleted_at, survey_id FROM survey_questions');
        $this->addSql('DROP TABLE survey_questions');
        $this->addSql('CREATE TABLE survey_questions (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, uuid VARCHAR(32) NOT NULL, type VARCHAR(50) NOT NULL, title VARCHAR(255) NOT NULL, visible BOOLEAN NOT NULL, min_options_limit INTEGER NOT NULL, max_options_limit INTEGER NOT NULL, draft BOOLEAN NOT NULL, required BOOLEAN NOT NULL, optional BOOLEAN NOT NULL, position INTEGER NOT NULL, extra_options CLOB NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, survey_id INTEGER NOT NULL, CONSTRAINT FK_2F8A16F8B3FE509D FOREIGN KEY (survey_id) REFERENCES surveys (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO survey_questions (id, uuid, type, title, visible, min_options_limit, max_options_limit, draft, required, optional, position, extra_options, created_at, updated_at, deleted_at, survey_id) SELECT id, uuid, type, title, visible, min_options_limit, max_options_limit, draft, required, optional, position, extra_options, created_at, updated_at, deleted_at, survey_id FROM __temp__survey_questions');
        $this->addSql('DROP TABLE __temp__survey_questions');
        $this->addSql('CREATE INDEX IDX_2F8A16F8B3FE509D ON survey_questions (survey_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__surveys AS SELECT id, user_id, title, draft, slug, password_required, password, extra_options, is_public, public_at, created_at, updated_at, deleted_at FROM surveys');
        $this->addSql('DROP TABLE surveys');
        $this->addSql('CREATE TABLE surveys (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER DEFAULT NULL, title VARCHAR(255) NOT NULL, draft BOOLEAN NOT NULL, slug VARCHAR(255) NOT NULL, password_required BOOLEAN NOT NULL, password VARCHAR(255) DEFAULT NULL, extra_options CLOB NOT NULL, is_public BOOLEAN DEFAULT 0 NOT NULL, public_at DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL)');
        $this->addSql('INSERT INTO surveys (id, user_id, title, draft, slug, password_required, password, extra_options, is_public, public_at, created_at, updated_at, deleted_at) SELECT id, user_id, title, draft, slug, password_required, password, extra_options, is_public, public_at, created_at, updated_at, deleted_at FROM __temp__surveys');
        $this->addSql('DROP TABLE __temp__surveys');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_AFA82EA7989D9B62 ON surveys (slug)');
    }
}
