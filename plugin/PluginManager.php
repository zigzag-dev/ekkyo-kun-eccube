<?php

namespace Plugin\EkkyoKun;

use Eccube\Plugin\AbstractPluginManager;

class PluginManager extends AbstractPluginManager
{
    // インストール時に、指定の処理を実行できます。(今回はなし)
    public function install($config, $app)
    {
    }

    // アンインストール時にマイグレーションの「down」メソッドを実行します
    public function uninstall($config, $app)
    {
    }

    // プラグイン有効時に、マイグレーションの「up」メソッドを実行します
    public function enable($config, $app)
    {
        $this->migrationSchema($app, __DIR__.'/Resource/doctrine/migration', $config['code']);
    }

    // プラグイン無効時に、指定の処理 ( ファイルの削除など ) を実行できます。(今回はなし)
    public function disable($config, $app)
    {
        $this->migrationSchema($app, __DIR__.'/Resource/doctrine/migration', $config['code'], 0);
    }

    // プラグインアップデート時に、指定の処理を実行できます。(今回はなし)
    public function update($config, $app)
    {
    }
}
