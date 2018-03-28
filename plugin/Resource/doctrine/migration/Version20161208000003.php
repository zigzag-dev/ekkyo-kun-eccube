<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Type;

class Version20161208000003 extends AbstractMigration
{
    const TABLE_NAME = 'plg_ekkyokun_configs';

    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $tableName = self::TABLE_NAME;
        $sql = <<<EOS
INSERT INTO `{$tableName}`
(`key`, `value`)
VALUES (?,?);
EOS;

        $this->addSql($sql, array(
            'token', null,
        ));
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
    }
}
