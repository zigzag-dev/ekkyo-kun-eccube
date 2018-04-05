<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;
use Plugin\EkkyoKun\Entity\Config;

class Version20161208000003 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $platform = $this->connection->getDatabasePlatform()->getName();
        if ($platform === 'postgresql' || $platform === 'sqlite') {
            $app = \Eccube\Application::getInstance();
            $em = $app['orm.em'];

            $config = new Config();
            $config->setKey('token');
            $config->setValue(null);
            $em->persist($config);
            $em->flush();
        } elseif ($platform === 'mysql') {
            $sql = <<<EOS
INSERT INTO `plg_ekkyokun_configs`
(`key`, `value`)
VALUES (?,?);
EOS;
            $this->addSql($sql, array(
                'token', null,
            ));
        }
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $app = \Eccube\Application::getInstance();
        $em = $app['orm.em'];
        $config = $em->getRepository('Plugin\EkkyoKun\Entity\Config')->findOneBy(array('key' => 'token'));
        $em->remove($config);
        $em->flush();
    }
}
