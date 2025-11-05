<?php
declare(strict_types=1);

/** 1) 箭头函数：自动继承外部作用域（适合简单一行） */

$factor = 10;
$times = fn(int $x): int => $x * $factor;
echo $times(3),PHP_EOL;

/** 2) 传统匿名函数：用 use 显式捕获（值捕获） */
$count = 0;
$adder = function (int $x) use ($count) {
    // 这里的 $count 是“值的副本”，改变它不会影响外部 $count
    return $x + $count;
};
echo $adder(5),PHP_EOL;
echo $count,PHP_EOL;        // 0（外部没变）

/** 3) 引用捕获 use (&$var)：真的修改外部变量（慎用） */
$total = 0;
$acc = function (int $x) use (&$total) {$total += $x;};
$acc(3);
$acc(7);
echo $total,PHP_EOL;

/** 4) foreach 引用的“陷阱”：用完一定 unset 引用变量 */
$tags = ['php','web'];
foreach ($tags as &$tag) {
    $tag = strtoupper($tag);
}
unset($tag);// ✅ 避免后续 $tag 仍指向最后一个元素
foreach ($tags as $tag) {echo $tag,PHP_EOL;}
echo PHP_EOL;

/** 5) 闭包返回闭包：工厂函数（常见实战写法） */
function make_multiplier(int $k):callable{
    return fn(int $x): int => $x * $k;
}
$mul3 = make_multiplier(3);
echo $mul3(7),PHP_EOL;

/**
 * 逐步发生了什么：
 *
 * 执行 make_multiplier(3)
 *
 * 形参 $k 取值为 3。
 *
 * return fn(int $x): int => $x * $k; 返回一个箭头函数，这个箭头函数里用到了 $k。
 *
 * 箭头函数会自动捕获外层变量 $k（按值），因此它“记住了 $k=3”。
 *
 * 把返回的函数赋给 $mul3
 *
 * 此时 $mul3 就是一个 callable（可调用的函数），等价于“fn($x) => $x * 3”。
 *
 * 调用 $mul3(7)
 *
 * 把 7 传给内层函数的参数 $x，执行体 $x * $k 就是 7 * 3，输出 21。
 */