<?php

echo $migrations = shell_exec('php vendor/bin/phoenix migrate -f json');
echo "\n\n";

// 刪除slim錯誤訊息
$jsonStart = strpos($migrations, '{"executed_migrations"');
$migrationResult = substr($migrations, $jsonStart);

// 進行unit test
// exec('php vendor/bin/phpunit tests', $output, $errorLevel);

// 如果有成功migrate，unit test也通過，執行git pull
// if (!empty($jsonStart) && $errorLevel == '0') {
echo shell_exec("C:\windows\system32\cmd.exe /c git-pull.bat");

    // 最近一筆migration
    // $executedMigrations = json_decode($migrationResult, true);

    // 測試rollback
    // $target = $executedMigrations['executed_migrations'][0]['datetime'] ?? null;
    // echo shell_exec('php vendor/bin/phoenix rollback --target ' . $target);
    // echo 'Rollback to ' . $target . ' complete.';
// }
