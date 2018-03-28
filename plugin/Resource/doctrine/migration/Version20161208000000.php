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
            'AE-0' => array('en' => 'United Arab Emirates', 'ja' => 'アラブ首長国連邦'),
            'AR-0' => array('en' => 'Argentina', 'ja' => 'アルゼンチン'),
            'AT-0' => array('en' => 'Austria', 'ja' => 'オーストリア'),
            'AU-0' => array('en' => 'Australia', 'ja' => 'オーストラリア'),
            'AZ-0' => array('en' => 'Azerbaijan', 'ja' => 'アゼルバイジャン'),
            'BB-0' => array('en' => 'Barbados', 'ja' => 'バルバドス'),
            'BD-0' => array('en' => 'Bangladesh', 'ja' => 'バングラデシュ'),
            'BE-0' => array('en' => 'Belgium', 'ja' => 'ベルギー'),
            'BG-0' => array('en' => 'Bulgaria', 'ja' => 'ブルガリア'),
            'BH-0' => array('en' => 'Bahrain', 'ja' => 'バーレーン'),
            'BN-0' => array('en' => 'Brunei', 'ja' => 'ブルネイ'),
            'BR-0' => array('en' => 'Brazil', 'ja' => 'ブラジル'),
            'BT-0' => array('en' => 'Bhutan', 'ja' => 'ブータン'),
            'BW-0' => array('en' => 'Botswana', 'ja' => 'ボツワナ'),
            'BY-0' => array('en' => 'Belarus', 'ja' => 'ベラルーシ'),
            'CA-0' => array('en' => 'Canada', 'ja' => 'カナダ'),
            'CH-0' => array('en' => 'Switzerland', 'ja' => 'スイス'),
            'CI-0' => array('en' => 'Ivory Coast', 'ja' => 'コートジボワール'),
            'CL-0' => array('en' => 'Chile', 'ja' => 'チリ'),
            'CN-0' => array('en' => 'China', 'ja' => '中国'),
            'CO-0' => array('en' => 'Colombia', 'ja' => 'コロンビア'),
            'CR-0' => array('en' => 'Costa Rica', 'ja' => 'コスタリカ'),
            'CU-0' => array('en' => 'Cuba', 'ja' => 'キューバ共和国'),
            'CY-0' => array('en' => 'Cyprus', 'ja' => 'キプロス'),
            'CZ-0' => array('en' => 'Czech Republic', 'ja' => 'チェコ'),
            'DE-0' => array('en' => 'Germany', 'ja' => 'ドイツ'),
            'DJ-0' => array('en' => 'Djibouti', 'ja' => 'ジブチ'),
            'DK-0' => array('en' => 'Denmark', 'ja' => 'デンマーク'),
            'DZ-0' => array('en' => 'Algeria', 'ja' => 'アルジェリア'),
            'EC-0' => array('en' => 'Ecuador', 'ja' => 'エクアドル'),
            'EE-0' => array('en' => 'Estonia', 'ja' => 'エストニア'),
            'EG-0' => array('en' => 'Egypt', 'ja' => 'エジプト'),
            'ES-0' => array('en' => 'Spain', 'ja' => 'スペイン'),
            'ET-0' => array('en' => 'Ethiopia', 'ja' => 'エチオピア'),
            'FI-0' => array('en' => 'Finland', 'ja' => 'フィンランド'),
            'FJ-0' => array('en' => 'Fiji', 'ja' => 'フィジー'),
            'FR-0' => array('en' => 'France', 'ja' => 'フランス'),
            'GA-0' => array('en' => 'Gabon', 'ja' => 'ガボン'),
            'GB-0' => array('en' => 'United Kingdom', 'ja' => 'イギリス'),
            'GH-0' => array('en' => 'Ghana', 'ja' => 'ガーナ'),
            'GR-0' => array('en' => 'Greece', 'ja' => 'ギリシャ'),
            'GU-0' => array('en' => 'Guam', 'ja' => 'グアム'),
            'HK-0' => array('en' => 'Hong Kong', 'ja' => '香港'),
            'HN-0' => array('en' => 'Honduras', 'ja' => 'ホンジュラス'),
            'HR-0' => array('en' => 'Croatia', 'ja' => 'クロアチア'),
            'HU-0' => array('en' => 'Hungary', 'ja' => 'ハンガリー'),
            'ID-0' => array('en' => 'Indonesia', 'ja' => 'インドネシア'),
            'IE-0' => array('en' => 'Ireland', 'ja' => 'アイルランド'),
            'IL-0' => array('en' => 'Israel', 'ja' => 'イスラエル'),
            'IN-0' => array('en' => 'India', 'ja' => 'インド'),
            'IQ-0' => array('en' => 'Iraq', 'ja' => 'イラク'),
            'IR-0' => array('en' => 'Iran', 'ja' => 'イラン'),
            'IS-0' => array('en' => 'Iceland', 'ja' => 'アイスランド'),
            'IT-0' => array('en' => 'Italy', 'ja' => 'イタリア'),
            'JM-0' => array('en' => 'Jamaica', 'ja' => 'ジャマイカ'),
            'JO-0' => array('en' => 'Jordan', 'ja' => 'ヨルダン'),
            'KE-0' => array('en' => 'Kenya', 'ja' => 'ケニア'),
            'KH-0' => array('en' => 'Cambodia', 'ja' => 'カンボジア'),
            'KR-0' => array('en' => 'South Korea', 'ja' => '大韓民国（韓国）'),
            'KW-0' => array('en' => 'Kuwait', 'ja' => 'クウェート'),
            'LA-0' => array('en' => 'Laos', 'ja' => 'ラオス'),
            'LI-0' => array('en' => 'Liechtenstein', 'ja' => 'リヒテンシュタイン'),
            'LK-0' => array('en' => 'Sri Lanka', 'ja' => 'スリランカ'),
            'LT-0' => array('en' => 'Lithuania', 'ja' => 'リトアニア'),
            'LU-0' => array('en' => 'Luxembourg', 'ja' => 'ルクセンブルグ'),
            'LV-0' => array('en' => 'Latvia', 'ja' => 'ラトビア'),
            'MA-0' => array('en' => 'Morocco', 'ja' => 'モロッコ'),
            'MC-0' => array('en' => 'Monaco', 'ja' => 'モナコ'),
            'MG-0' => array('en' => 'Madagascar', 'ja' => 'マダガスカル'),
            'MK-0' => array('en' => 'Macedonia', 'ja' => 'マケドニア/旧ユーゴスラビア'),
            'MM-0' => array('en' => 'Myanmar', 'ja' => 'ミャンマー連邦'),
            'MN-0' => array('en' => 'Mongolia', 'ja' => 'モンゴル'),
            'MO-0' => array('en' => 'Macau', 'ja' => 'マカオ'),
            'MP-0' => array('en' => 'Northern Mariana Islands', 'ja' => '北マリアナ諸島'),
            'MT-0' => array('en' => 'Malta', 'ja' => 'マルタ'),
            'MU-0' => array('en' => 'Mauritius', 'ja' => 'モーリシャス'),
            'MV-0' => array('en' => 'Maldives', 'ja' => 'モルディブ'),
            'MX-0' => array('en' => 'Mexico', 'ja' => 'メキシコ'),
            'MY-0' => array('en' => 'Malaysia', 'ja' => 'マレーシア'),
            'NC-0' => array('en' => 'New Caledonia', 'ja' => 'ニューカレドニア'),
            'NG-0' => array('en' => 'Nigeria', 'ja' => 'ナイジェリア'),
            'NL-0' => array('en' => 'Netherlands', 'ja' => 'オランダ'),
            'NO-0' => array('en' => 'Norway', 'ja' => 'ノルウェー'),
            'NP-0' => array('en' => 'Nepal', 'ja' => 'ネパール'),
            'NZ-0' => array('en' => 'New Zealand', 'ja' => 'ニュージーランド'),
            'OM-0' => array('en' => 'Oman', 'ja' => 'オマーン'),
            'PA-0' => array('en' => 'Panama', 'ja' => 'パナマ'),
            'PE-0' => array('en' => 'Peru', 'ja' => 'ペルー'),
            'PG-0' => array('en' => 'Papua New Guinea', 'ja' => 'パプアニューギニア'),
            'PH-0' => array('en' => 'Philippines', 'ja' => 'フィリピン'),
            'PK-0' => array('en' => 'Pakistan', 'ja' => 'パキスタン'),
            'PL-0' => array('en' => 'Poland', 'ja' => 'ポーランド'),
            'PT-0' => array('en' => 'Portugal', 'ja' => 'ポルトガル'),
            'PY-0' => array('en' => 'Paraguay', 'ja' => 'パラグアイ'),
            'QA-0' => array('en' => 'Qatar', 'ja' => 'カタール'),
            'RO-0' => array('en' => 'Romania', 'ja' => 'ルーマニア'),
            'RU-0' => array('en' => 'Russia', 'ja' => 'ロシア'),
            'RW-0' => array('en' => 'Rwanda', 'ja' => 'ルワンダ'),
            'SA-0' => array('en' => 'Saudi Arabia', 'ja' => 'サウジアラビア'),
            'SB-0' => array('en' => 'Solomon Islands', 'ja' => 'ソロモン'),
            'SD-0' => array('en' => 'Sudan', 'ja' => 'スーダン'),
            'SE-0' => array('en' => 'Sweden', 'ja' => 'スウェーデン'),
            'SG-0' => array('en' => 'Singapore', 'ja' => 'シンガポール'),
            'SI-0' => array('en' => 'Slovenia', 'ja' => 'スロベニア'),
            'SK-0' => array('en' => 'Slovak Republic', 'ja' => 'スロバキア'),
            'SL-0' => array('en' => 'Sierra Leone', 'ja' => 'シエラレオネ共和国'),
            'SN-0' => array('en' => 'Senegal', 'ja' => 'セネガル'),
            'SS-0' => array('en' => 'South Sudan', 'ja' => '南スーダン'),
            'SV-0' => array('en' => 'El Salvador', 'ja' => 'エルサルバドル'),
            'SY-0' => array('en' => 'Syria', 'ja' => 'シリア'),
            'TG-0' => array('en' => 'Togo', 'ja' => 'トーゴ'),
            'TH-0' => array('en' => 'Thailand', 'ja' => 'タイ'),
            'TN-0' => array('en' => 'Tunisia', 'ja' => 'チュニジア'),
            'TR-0' => array('en' => 'Turkey', 'ja' => 'トルコ'),
            'TT-0' => array('en' => 'Trinidad & Tobago', 'ja' => 'トリニダード・トバゴ'),
            'TW-0' => array('en' => 'Taiwan', 'ja' => '台湾'),
            'TZ-0' => array('en' => 'Tanzania', 'ja' => 'タンザニア'),
            'UA-0' => array('en' => 'Ukraine', 'ja' => 'ウクライナ'),
            'UG-0' => array('en' => 'Uganda', 'ja' => 'ウガンダ'),
            'US-0' => array('en' => 'U.S.', 'ja' => 'アメリカ合衆国'),
            'UY-0' => array('en' => 'Uruguay', 'ja' => 'ウルグアイ'),
            'VE-0' => array('en' => 'Venezuela', 'ja' => 'ベネズエラ'),
            'VN-0' => array('en' => 'Vietnam', 'ja' => 'ベトナム'),
            'ZA-0' => array('en' => 'South Africa', 'ja' => '南アフリカ'),
            'ZW-0' => array('en' => 'Zimbabwe', 'ja' => 'ジンバブエ'),
        );
    }
}
