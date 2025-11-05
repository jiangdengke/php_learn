<?php
declare(strict_types=1);
// 1.解构（list 解包）
$nums = [10,20,30];
[$a, $b, $c] = $nums;
echo "a=$a,b=$b,c=$c\n";
// 2.关联数组的按键结构
$user = ['id'=>1,'name'=>'jiang','vip'=>true];
['name'=>$n,'vip'=>$vip] = $user;
echo "name=$n vip=".($vip ? 'yes' : 'no'),PHP_EOL;

// 3.展开，把多个数组合并为一个（不会修改原数组）

$more = [40,50];
$merged = [...$nums, ...$more];
print_r($merged);

// 4.统计与查找：count
echo "count(merged)= ", count($merged),PHP_EOL;


$found20 = in_array(20,$merged,true); //在数组 $merged 里找数字 20
$foundStr20 = in_array("20",$merged,true);
var_dump($found20,$foundStr20);