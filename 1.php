<?php
declare(strict_types=1);

/**输出 & 变量 & 字符串 */
echo "Hello PHP!\n";

$age = 20;
$name = "Jiangdengke\n";
echo "Hi,$name";
echo "Age = ".$age."岁\n";

$price = 18.8;
$isVip = true;
$nickname = null;
var_dump($price,$isVip,$nickname);

echo "拼接：".$name."年龄".$age."\n";
echo "插值: $name 的年龄是$age\n";

$bio = <<<TXT
你好，我是 $name
我今年 $age 岁
TXT;
echo $bio . "\n";
function add(int $a,int $b): int {
    return $a + $b;
}
echo add(2,4);