<?php
declare(strict_types=1);

$nums = [10,20,30];
$user = ['id' => 1, 'name' => 'jiang', 'vip' => true];

echo $nums[0], PHP_EOL; /**PHP_EOL 是一个内置常量，表示“当前操作系统的换行符”（End Of Line）。
在 Linux / macOS：PHP_EOL 等于 "\n"
在 Windows：PHP_EOL 等于 "\r\n" */

$nums[] = 40;       // 追加到尾部
$user['score'] = 88;// 新增一个键值

echo "---foreach 值 ---\n";
foreach($nums as $v) {
    echo $v," ";
}
echo PHP_EOL;

echo "---foreach 值 ---\n";
foreach($user as $k => $v) {
    echo $k, " => ";
    var_export($v);
    echo PHP_EOL;
}