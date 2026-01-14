<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260114133714 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create survey table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('
            CREATE TABLE survey (
                id INT AUTO_INCREMENT NOT NULL,
                user_id INT NOT NULL,

                name VARCHAR(255) NOT NULL,
                draft TINYINT(1) NOT NULL,
                slug VARCHAR(255) NOT NULL,
                password VARCHAR(255) DEFAULT NULL,

                public_at DATETIME DEFAULT NULL,
                created_at DATETIME NOT NULL,
                updated_at DATETIME NOT NULL,
                deleted_at DATETIME DEFAULT NULL,

                INDEX IDX_SURVEY_USER (user_id),
                UNIQUE INDEX UNIQ_SURVEY_SLUG (slug),
                PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        ');

        $this->addSql('
            ALTER TABLE survey
            ADD CONSTRAINT FK_SURVEY_USER
            FOREIGN KEY (user_id) REFERENCES user (id)
            ON DELETE CASCADE
        ');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE survey DROP FOREIGN KEY FK_SURVEY_USER');
        $this->addSql('DROP TABLE survey');
    }
}
