<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Type;

class Version20161208000000 extends AbstractMigration
{
    const TABLE_NAME = 'plg_ekkyokun_countries';
    /**
     * @param Schema $schema
     * ./vendor/bin/doctrine orm:generate:entities --filter="Plugin\\EkkyoKun\\Entity\\Product" --extend="Eccube\\Entity\\AbstractEntity" app
     */
    public function up(Schema $schema)
    {
        $countries = $this->getCountries();
        $params = array();
        $placeholders = array();
        $a = 1;
        foreach ($countries as $code => $country) {
            $params[] = $a;
            $params[] = substr($code, 0, 2);
            $params[] = $country['ja'];
            $params[] = $country['en'];
            $params[] = 0;
            $placeholders[] = '(?,?,?,?,?)';
            $a++;
        }

        $tableName = self::TABLE_NAME;
        $placeholders = implode(',', $placeholders);
        $sql = <<<EOS
INSERT INTO `{$tableName}`
(`id`, `code`, `name`, `name_en`, `deny`)
VALUES {$placeholders};
EOS;

        $this->addSql($sql, $params);
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
    }

    /**
     * @return array
     */
    private function getCountries()
    {
        return array(
            'AE-0' => ['en' => 'United Arab Emirates', 'ja' => 'アラブ首長国連邦'],
            'AR-0' => ['en' => 'Argentina', 'ja' => 'アルゼンチン'],
            'AT-0' => ['en' => 'Austria', 'ja' => 'オーストリア'],
            'AU-0' => ['en' => 'Australia', 'ja' => 'オーストラリア'],
            'AZ-0' => ['en' => 'Azerbaijan', 'ja' => 'アゼルバイジャン'],
            'BB-0' => ['en' => 'Barbados', 'ja' => 'バルバドス'],
            'BD-0' => ['en' => 'Bangladesh', 'ja' => 'バングラデシュ'],
            'BE-0' => ['en' => 'Belgium', 'ja' => 'ベルギー'],
            'BG-0' => ['en' => 'Bulgaria', 'ja' => 'ブルガリア'],
            'BH-0' => ['en' => 'Bahrain', 'ja' => 'バーレーン'],
            'BN-0' => ['en' => 'Brunei', 'ja' => 'ブルネイ'],
            'BR-0' => ['en' => 'Brazil', 'ja' => 'ブラジル'],
            'BT-0' => ['en' => 'Bhutan', 'ja' => 'ブータン'],
            'BW-0' => ['en' => 'Botswana', 'ja' => 'ボツワナ'],
            'BY-0' => ['en' => 'Belarus', 'ja' => 'ベラルーシ'],
            'CA-0' => ['en' => 'Canada', 'ja' => 'カナダ'],
            'CH-0' => ['en' => 'Switzerland', 'ja' => 'スイス'],
            'CI-0' => ['en' => 'Ivory Coast', 'ja' => 'コートジボワール'],
            'CL-0' => ['en' => 'Chile', 'ja' => 'チリ'],
            'CN-0' => ['en' => 'China', 'ja' => '中国'],
            'CO-0' => ['en' => 'Colombia', 'ja' => 'コロンビア'],
            'CR-0' => ['en' => 'Costa Rica', 'ja' => 'コスタリカ'],
            'CU-0' => ['en' => 'Cuba', 'ja' => 'キューバ共和国'],
            'CY-0' => ['en' => 'Cyprus', 'ja' => 'キプロス'],
            'CZ-0' => ['en' => 'Czech Republic', 'ja' => 'チェコ'],
            'DE-0' => ['en' => 'Germany', 'ja' => 'ドイツ'],
            'DJ-0' => ['en' => 'Djibouti', 'ja' => 'ジブチ'],
            'DK-0' => ['en' => 'Denmark', 'ja' => 'デンマーク'],
            'DZ-0' => ['en' => 'Algeria', 'ja' => 'アルジェリア'],
            'EC-0' => ['en' => 'Ecuador', 'ja' => 'エクアドル'],
            'EE-0' => ['en' => 'Estonia', 'ja' => 'エストニア'],
            'EG-0' => ['en' => 'Egypt', 'ja' => 'エジプト'],
            'ES-0' => ['en' => 'Spain', 'ja' => 'スペイン'],
            'ET-0' => ['en' => 'Ethiopia', 'ja' => 'エチオピア'],
            'FI-0' => ['en' => 'Finland', 'ja' => 'フィンランド'],
            'FJ-0' => ['en' => 'Fiji', 'ja' => 'フィジー'],
            'FR-0' => ['en' => 'France', 'ja' => 'フランス'],
            'GA-0' => ['en' => 'Gabon', 'ja' => 'ガボン'],
            'GB-0' => ['en' => 'United Kingdom', 'ja' => 'イギリス'],
            'GH-0' => ['en' => 'Ghana', 'ja' => 'ガーナ'],
            'GR-0' => ['en' => 'Greece', 'ja' => 'ギリシャ'],
            'GU-0' => ['en' => 'Guam', 'ja' => 'グアム'],
            'HK-0' => ['en' => 'Hong Kong', 'ja' => '香港'],
            'HN-0' => ['en' => 'Honduras', 'ja' => 'ホンジュラス'],
            'HR-0' => ['en' => 'Croatia', 'ja' => 'クロアチア'],
            'HU-0' => ['en' => 'Hungary', 'ja' => 'ハンガリー'],
            'ID-0' => ['en' => 'Indonesia', 'ja' => 'インドネシア'],
            'IE-0' => ['en' => 'Ireland', 'ja' => 'アイルランド'],
            'IL-0' => ['en' => 'Israel', 'ja' => 'イスラエル'],
            'IN-0' => ['en' => 'India', 'ja' => 'インド'],
            'IQ-0' => ['en' => 'Iraq', 'ja' => 'イラク'],
            'IR-0' => ['en' => 'Iran', 'ja' => 'イラン'],
            'IS-0' => ['en' => 'Iceland', 'ja' => 'アイスランド'],
            'IT-0' => ['en' => 'Italy', 'ja' => 'イタリア'],
            'JM-0' => ['en' => 'Jamaica', 'ja' => 'ジャマイカ'],
            'JO-0' => ['en' => 'Jordan', 'ja' => 'ヨルダン'],
            'KE-0' => ['en' => 'Kenya', 'ja' => 'ケニア'],
            'KH-0' => ['en' => 'Cambodia', 'ja' => 'カンボジア'],
            'KR-0' => ['en' => 'South Korea', 'ja' => '大韓民国（韓国）'],
            'KW-0' => ['en' => 'Kuwait', 'ja' => 'クウェート'],
            'LA-0' => ['en' => 'Laos', 'ja' => 'ラオス'],
            'LI-0' => ['en' => 'Liechtenstein', 'ja' => 'リヒテンシュタイン'],
            'LK-0' => ['en' => 'Sri Lanka', 'ja' => 'スリランカ'],
            'LT-0' => ['en' => 'Lithuania', 'ja' => 'リトアニア'],
            'LU-0' => ['en' => 'Luxembourg', 'ja' => 'ルクセンブルグ'],
            'LV-0' => ['en' => 'Latvia', 'ja' => 'ラトビア'],
            'MA-0' => ['en' => 'Morocco', 'ja' => 'モロッコ'],
            'MC-0' => ['en' => 'Monaco', 'ja' => 'モナコ'],
            'MG-0' => ['en' => 'Madagascar', 'ja' => 'マダガスカル'],
            'MK-0' => ['en' => 'Macedonia', 'ja' => 'マケドニア/旧ユーゴスラビア'],
            'MM-0' => ['en' => 'Myanmar', 'ja' => 'ミャンマー連邦'],
            'MN-0' => ['en' => 'Mongolia', 'ja' => 'モンゴル'],
            'MO-0' => ['en' => 'Macau', 'ja' => 'マカオ'],
            'MP-0' => ['en' => 'Northern Mariana Islands', 'ja' => '北マリアナ諸島'],
            'MT-0' => ['en' => 'Malta', 'ja' => 'マルタ'],
            'MU-0' => ['en' => 'Mauritius', 'ja' => 'モーリシャス'],
            'MV-0' => ['en' => 'Maldives', 'ja' => 'モルディブ'],
            'MX-0' => ['en' => 'Mexico', 'ja' => 'メキシコ'],
            'MY-0' => ['en' => 'Malaysia', 'ja' => 'マレーシア'],
            'NC-0' => ['en' => 'New Caledonia', 'ja' => 'ニューカレドニア'],
            'NG-0' => ['en' => 'Nigeria', 'ja' => 'ナイジェリア'],
            'NL-0' => ['en' => 'Netherlands', 'ja' => 'オランダ'],
            'NO-0' => ['en' => 'Norway', 'ja' => 'ノルウェー'],
            'NP-0' => ['en' => 'Nepal', 'ja' => 'ネパール'],
            'NZ-0' => ['en' => 'New Zealand', 'ja' => 'ニュージーランド'],
            'OM-0' => ['en' => 'Oman', 'ja' => 'オマーン'],
            'PA-0' => ['en' => 'Panama', 'ja' => 'パナマ'],
            'PE-0' => ['en' => 'Peru', 'ja' => 'ペルー'],
            'PG-0' => ['en' => 'Papua New Guinea', 'ja' => 'パプアニューギニア'],
            'PH-0' => ['en' => 'Philippines', 'ja' => 'フィリピン'],
            'PK-0' => ['en' => 'Pakistan', 'ja' => 'パキスタン'],
            'PL-0' => ['en' => 'Poland', 'ja' => 'ポーランド'],
            'PT-0' => ['en' => 'Portugal', 'ja' => 'ポルトガル'],
            'PY-0' => ['en' => 'Paraguay', 'ja' => 'パラグアイ'],
            'QA-0' => ['en' => 'Qatar', 'ja' => 'カタール'],
            'RO-0' => ['en' => 'Romania', 'ja' => 'ルーマニア'],
            'RU-0' => ['en' => 'Russia', 'ja' => 'ロシア'],
            'RW-0' => ['en' => 'Rwanda', 'ja' => 'ルワンダ'],
            'SA-0' => ['en' => 'Saudi Arabia', 'ja' => 'サウジアラビア'],
            'SB-0' => ['en' => 'Solomon Islands', 'ja' => 'ソロモン'],
            'SD-0' => ['en' => 'Sudan', 'ja' => 'スーダン'],
            'SE-0' => ['en' => 'Sweden', 'ja' => 'スウェーデン'],
            'SG-0' => ['en' => 'Singapore', 'ja' => 'シンガポール'],
            'SI-0' => ['en' => 'Slovenia', 'ja' => 'スロベニア'],
            'SK-0' => ['en' => 'Slovak Republic', 'ja' => 'スロバキア'],
            'SL-0' => ['en' => 'Sierra Leone', 'ja' => 'シエラレオネ共和国'],
            'SN-0' => ['en' => 'Senegal', 'ja' => 'セネガル'],
            'SS-0' => ['en' => 'South Sudan', 'ja' => '南スーダン'],
            'SV-0' => ['en' => 'El Salvador', 'ja' => 'エルサルバドル'],
            'SY-0' => ['en' => 'Syria', 'ja' => 'シリア'],
            'TG-0' => ['en' => 'Togo', 'ja' => 'トーゴ'],
            'TH-0' => ['en' => 'Thailand', 'ja' => 'タイ'],
            'TN-0' => ['en' => 'Tunisia', 'ja' => 'チュニジア'],
            'TR-0' => ['en' => 'Turkey', 'ja' => 'トルコ'],
            'TT-0' => ['en' => 'Trinidad & Tobago', 'ja' => 'トリニダード・トバゴ'],
            'TW-0' => ['en' => 'Taiwan', 'ja' => '台湾'],
            'TZ-0' => ['en' => 'Tanzania', 'ja' => 'タンザニア'],
            'UA-0' => ['en' => 'Ukraine', 'ja' => 'ウクライナ'],
            'UG-0' => ['en' => 'Uganda', 'ja' => 'ウガンダ'],
            'US-0' => ['en' => 'U.S.(West Region)', 'ja' => 'アメリカ合衆国（西部）'],
//            'US-1' => ['en' => 'U.S.(Rest of Country)', 'ja' => 'アメリカ合衆国（その他）'],
            'UY-0' => ['en' => 'Uruguay', 'ja' => 'ウルグアイ'],
            'VE-0' => ['en' => 'Venezuela', 'ja' => 'ベネズエラ'],
            'VN-0' => ['en' => 'Vietnam', 'ja' => 'ベトナム'],
            'ZA-0' => ['en' => 'South Africa', 'ja' => '南アフリカ'],
            'ZW-0' => ['en' => 'Zimbabwe', 'ja' => 'ジンバブエ'],
        );
    }
}
