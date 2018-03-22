<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Type;

class Version20150706204400 extends AbstractMigration
{
    const TABLE_NAME = 'plg_ekkyokun_countries';
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $table = $schema->createTable(self::TABLE_NAME);
        $table->addColumn('id', Type::INTEGER, array(
            'notnull' => true,
            'autoincrement' => true,
        ));
        $table->addColumn('code', Type::STRING, array(
            'length' => 4,
        ));
        $table->addColumn('name', Type::STRING, array(
            'length' => 32,
        ));
        $table->addColumn('name_en', Type::STRING, array(
            'length' => 32,
        ));
        $table->addColumn('deny', Type::BOOLEAN, array(
            'default' => false,
        ));
        $table->setPrimaryKey(array('id'));
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $schema->dropTable(self::TABLE_NAME);
    }
}
