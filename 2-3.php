<?php
declare(strict_types=1);

$nums = [1,2,3,4,5];
$names = ['john','JANE','bob'];

// 1.map:逐个变换，不改原数组
// 对数组里的每个元素执行一次“回调函数”，把回调的返回值组成新数组返回（原数组不改）。
$doubled = array_map(fn(int $x): int => $x * 2,$nums);
print_r($doubled);
/**
 * array_map(回调, $names)：对 $names 里的每个元素执行一次回调，不改原数组，把回调的返回值组成新数组返回。
 *
 * fn($s) => ...：箭头函数（匿名函数的简写）。参数 $s 是数组里的每个字符串。
 *
 * strtolower($s)：先把整条字符串变成全小写。
 *
 * ucfirst(...)：再把第一个字符转成大写（Upper Case First）。
 */
$normalized = array_map(fn($s)=>ucfirst(strtolower($s)),$names);
print_r($normalized);

// 2.filter: 按条件保留
$even = array_filter($nums,fn(int $x): bool => $x % 2 === 0);
print_r($even);
$even = array_values($even); //重排索引
print_r($even);

// 3.reduce:把一堆值折叠为一个
$sum = array_reduce($nums,fn(int $carry,int $x): int => $carry + $x,0);
echo $sum.PHP_EOL;