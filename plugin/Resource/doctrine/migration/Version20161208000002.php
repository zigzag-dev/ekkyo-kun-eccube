<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Type;

class Version20161208000002 extends AbstractMigration
{
    const TABLE_NAME = 'plg_ekkyokun_configs';

    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $table = $schema->createTable(self::TABLE_NAME);
        $table->addColumn('id', Type::INTEGER, array(
            'notnull' => true,
            'autoincrement' => true,
            'unsigned' => true,
        ));
        $table->addColumn('key', Type::STRING, array(
            'notnull' => true,
            'length' => 32,
        ));
        $table->addColumn('value', Type::STRING, array(
            'notnull' => false,
            'length' => 255,
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
