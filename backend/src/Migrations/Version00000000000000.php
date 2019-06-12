<?php
/**
 * Created by PhpStorm.
 * User: Andrzej
 * Date: 04.12.2018
 * Time: 12:07
 */

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

class Version00000000000000 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema): void
    {
        $this->addSql("CREATE TYPE enum_unit_type AS ENUM('KILO', 'PIECE', 'BUNCH', 'GRAMS', 'LITER', 'MILLILITERS')");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema): void
    {
        $this->addSql('DROP TYPE IF EXISTS enum_unit_type');

    }
}
