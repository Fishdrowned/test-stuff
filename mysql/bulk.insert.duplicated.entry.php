<?php
include dirname(__DIR__) . '/php/.include.php';
include dirname(__DIR__) . '/php/.db.php';

use Swoole\Process;

$processes = [];
for ($i = 10; $i > 0; --$i) {
    $processes[] = $process = new Process(function () use ($i) {
        // Keep connect for odd processes
//        $i & 1 and Db::init('192.168.202.200', 'appgame_passport_test', 'test', 'ajtxH3Qt5HFhvfej');
        Db::init('192.168.202.200', 'appgame_passport_test', 'test', 'ajtxH3Qt5HFhvfej');
        $stressTime = 3600;
        $start = time();
        while (($now = time()) - $start < $stressTime) {
//            $now = microtime();
            Timer::start();
            // Reconnect for even processes
//            $i & 1 or Db::init('192.168.202.200', 'appgame_passport_test', 'test', 'ajtxH3Qt5HFhvfej');
            if (($error = Db::getPdo()->errorInfo()) && $error[0] * 1) {
//                file_put_contents(__DIR__ . '/exception.log', date('Y-m-d H:i:s ') . var_export($error, 1) . PHP_EOL, FILE_APPEND);
            }
            $insert = <<<SQL
INSERT INTO `xx_profiles` (`id`, `user_id`, `provider`, `identifier`, `webSiteURL`, `profileURL`, `photoURL`, `displayName`, `description`, `firstName`, `lastName`, `gender`, `language`, `age`, `birthDay`, `birthMonth`, `birthYear`, `email`, `emailVerified`, `phone`, `address`, `country`, `region`, `city`, `zip`, `username`, `coverInfoURL`, `created_at`, `updated_at`, `comment`)
VALUES (NULL, NULL, 'Uc', 'Uc|{$now}', NULL, NULL, NULL, '九游玩家747971505', '{"accountId":"0d31fb35eacbdee64cf2c78eb5768b4e","nickName":"\u4e5d\u6e38\u73a9\u5bb6747971505","creator":"JY"}', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2016-08-24 08:39:14', '2016-08-24 08:39:14', 'Registered from Uc');
SQL;
            try {
                $select = "SELECT * FROM `xx_profiles` WHERE `identifier` = 'Uc|{$now}'";
                if (Db::getPdo()->query($select)->fetch()) {
                    continue;
                }
                Db::getPdo()->exec($insert);
                if (($error = Db::getPdo()->errorInfo()) && $error[0] * 1) {
//                    file_put_contents(__DIR__ . '/exception.log', date('Y-m-d H:i:s ') . var_export($error, 1) . PHP_EOL, FILE_APPEND);
                }
                $result = Db::getPdo()->query($select)->fetchAll();
                if (count($result) > 1) {
                    $duplicatedIds = [];
                    foreach ($result as $row) {
                        $duplicatedIds[$row['id']] = $row['id'];
                    }
                    krsort($duplicatedIds);
                    $id = array_pop($duplicatedIds);
                    $duplicatedIds = implode("', '", $duplicatedIds);
                    Db::getPdo()->exec("DELETE FROM `xx_profiles` WHERE `id` IN ('{$duplicatedIds}')");
                }
            } catch (Exception $e) {
//                file_put_contents(__DIR__ . '/exception.log', date('Y-m-d H:i:s ') . $e->__toString() . PHP_EOL, FILE_APPEND);
            }
            usleep(1e5);
//            $i & 1 or Db::close();
            file_put_contents(__DIR__ . '/exception.log', date('Y-m-d H:i:s ') . Timer::stop() . PHP_EOL, FILE_APPEND);
        }
//        $i & 1 and Db::close();
    });
    $process->start();
}
Process::wait();
