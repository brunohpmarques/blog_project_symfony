<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200916200531 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE UNIQUE INDEX UNIQ_23A0E662B36786B ON article (title)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_64C19C15E237E06 ON category (name)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON user (email)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_23A0E662B36786B ON article');
        $this->addSql('DROP INDEX UNIQ_64C19C15E237E06 ON category');
        $this->addSql('DROP INDEX UNIQ_8D93D649E7927C74 ON user');
    }
}
