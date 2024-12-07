<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20241207234923 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE fruits (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, quantity_in_gram INTEGER NOT NULL)');
        $this->addSql('CREATE TABLE vegetables (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, quantity_in_gram INTEGER NOT NULL)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE fruits');
        $this->addSql('DROP TABLE vegetables');
    }
}
