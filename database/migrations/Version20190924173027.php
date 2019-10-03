<?php

namespace Database\Migrations;

use Doctrine\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;

class Version20190924173027 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TABLE episodios (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, temporada_id INTEGER DEFAULT NULL, numero INTEGER NOT NULL, assistido BOOLEAN DEFAULT \'0\' NOT NULL)');
        $this->addSql('CREATE INDEX IDX_C7C10056E1CF8A8 ON episodios (temporada_id)');
        $this->addSql('CREATE TABLE notifications (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER DEFAULT NULL, level VARCHAR(255) NOT NULL, message VARCHAR(255) NOT NULL, action_text VARCHAR(255) NOT NULL, action_url VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE INDEX IDX_6000B0D3A76ED395 ON notifications (user_id)');
        $this->addSql('CREATE TABLE series (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TABLE temporadas (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, serie_id INTEGER DEFAULT NULL, numero INTEGER NOT NULL)');
        $this->addSql('CREATE INDEX IDX_AE446BE4D94388BD ON temporadas (serie_id)');
        $this->addSql('CREATE TABLE users (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, remember_token VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP TABLE episodios');
        $this->addSql('DROP TABLE notifications');
        $this->addSql('DROP TABLE series');
        $this->addSql('DROP TABLE temporadas');
        $this->addSql('DROP TABLE users');
    }
}
