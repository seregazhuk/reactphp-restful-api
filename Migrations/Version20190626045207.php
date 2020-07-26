<?php

declare(strict_types=1);

namespace App\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20190626045207 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $sql = <<< SQL
CREATE TABLE products (
    id INT UNSIGNED AUTO_INCREMENT NOT NULL,
    name VARCHAR (60) NOT NULL,
    price DECIMAL NOT NULL,
    PRIMARY KEY(id)
)
SQL;

        $this->addSql($sql);
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE products');
    }
}
