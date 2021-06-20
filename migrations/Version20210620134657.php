<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210620134657 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE library (id_book INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(50) NOT NULL, author VARCHAR(50) NOT NULL, isbn VARCHAR(50) NOT NULL, pic VARCHAR(200) NOT NULL)');
        $this->addSql('CREATE TABLE score (id_score INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(50) NOT NULL, player_score INTEGER NOT NULL, computer_score INTEGER NOT NULL, points INTEGER NOT NULL, dice_stat VARCHAR(400) NOT NULL)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE library');
        $this->addSql('DROP TABLE score');
    }
}
