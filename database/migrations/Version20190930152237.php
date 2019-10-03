<?php

namespace Database\Migrations;

use Doctrine\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;

class Version20190930152237 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX IDX_C7C10056E1CF8A8');
        $this->addSql('CREATE TEMPORARY TABLE __temp__episodios AS SELECT id, temporada_id, numero, assistido FROM episodios');
        $this->addSql('DROP TABLE episodios');
        $this->addSql('CREATE TABLE episodios (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, temporada_id INTEGER DEFAULT NULL, numero INTEGER NOT NULL, assistido BOOLEAN DEFAULT \'0\' NOT NULL, CONSTRAINT FK_C7C10056E1CF8A8 FOREIGN KEY (temporada_id) REFERENCES temporadas (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO episodios (id, temporada_id, numero, assistido) SELECT id, temporada_id, numero, assistido FROM __temp__episodios');
        $this->addSql('DROP TABLE __temp__episodios');
        $this->addSql('CREATE INDEX IDX_C7C10056E1CF8A8 ON episodios (temporada_id)');
        $this->addSql('DROP INDEX IDX_6000B0D3A76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__notifications AS SELECT id, user_id, level, message, action_text, action_url FROM notifications');
        $this->addSql('DROP TABLE notifications');
        $this->addSql('CREATE TABLE notifications (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER DEFAULT NULL, level VARCHAR(255) NOT NULL COLLATE BINARY, message VARCHAR(255) NOT NULL COLLATE BINARY, action_text VARCHAR(255) NOT NULL COLLATE BINARY, action_url VARCHAR(255) NOT NULL COLLATE BINARY, CONSTRAINT FK_6000B0D3A76ED395 FOREIGN KEY (user_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO notifications (id, user_id, level, message, action_text, action_url) SELECT id, user_id, level, message, action_text, action_url FROM __temp__notifications');
        $this->addSql('DROP TABLE __temp__notifications');
        $this->addSql('CREATE INDEX IDX_6000B0D3A76ED395 ON notifications (user_id)');
        $this->addSql('DROP INDEX IDX_AE446BE4D94388BD');
        $this->addSql('CREATE TEMPORARY TABLE __temp__temporadas AS SELECT id, serie_id, numero FROM temporadas');
        $this->addSql('DROP TABLE temporadas');
        $this->addSql('CREATE TABLE temporadas (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, serie_id INTEGER DEFAULT NULL, numero INTEGER NOT NULL, CONSTRAINT FK_AE446BE4D94388BD FOREIGN KEY (serie_id) REFERENCES series (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO temporadas (id, serie_id, numero) SELECT id, serie_id, numero FROM __temp__temporadas');
        $this->addSql('DROP TABLE __temp__temporadas');
        $this->addSql('CREATE INDEX IDX_AE446BE4D94388BD ON temporadas (serie_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX IDX_C7C10056E1CF8A8');
        $this->addSql('CREATE TEMPORARY TABLE __temp__episodios AS SELECT id, temporada_id, numero, assistido FROM episodios');
        $this->addSql('DROP TABLE episodios');
        $this->addSql('CREATE TABLE episodios (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, temporada_id INTEGER DEFAULT NULL, numero INTEGER NOT NULL, assistido BOOLEAN DEFAULT \'0\' NOT NULL)');
        $this->addSql('INSERT INTO episodios (id, temporada_id, numero, assistido) SELECT id, temporada_id, numero, assistido FROM __temp__episodios');
        $this->addSql('DROP TABLE __temp__episodios');
        $this->addSql('CREATE INDEX IDX_C7C10056E1CF8A8 ON episodios (temporada_id)');
        $this->addSql('DROP INDEX IDX_6000B0D3A76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__notifications AS SELECT id, user_id, level, message, action_text, action_url FROM notifications');
        $this->addSql('DROP TABLE notifications');
        $this->addSql('CREATE TABLE notifications (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER DEFAULT NULL, level VARCHAR(255) NOT NULL, message VARCHAR(255) NOT NULL, action_text VARCHAR(255) NOT NULL, action_url VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO notifications (id, user_id, level, message, action_text, action_url) SELECT id, user_id, level, message, action_text, action_url FROM __temp__notifications');
        $this->addSql('DROP TABLE __temp__notifications');
        $this->addSql('CREATE INDEX IDX_6000B0D3A76ED395 ON notifications (user_id)');
        $this->addSql('DROP INDEX IDX_AE446BE4D94388BD');
        $this->addSql('CREATE TEMPORARY TABLE __temp__temporadas AS SELECT id, serie_id, numero FROM temporadas');
        $this->addSql('DROP TABLE temporadas');
        $this->addSql('CREATE TABLE temporadas (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, serie_id INTEGER DEFAULT NULL, numero INTEGER NOT NULL)');
        $this->addSql('INSERT INTO temporadas (id, serie_id, numero) SELECT id, serie_id, numero FROM __temp__temporadas');
        $this->addSql('DROP TABLE __temp__temporadas');
        $this->addSql('CREATE INDEX IDX_AE446BE4D94388BD ON temporadas (serie_id)');
    }
}
