<?php
declare(strict_types=1);

// 1.参数类型+返回类型
function add(int $a, int $b): int {
    return $a + $b;
}

echo "add = ",add(2,3),PHP_EOL;

// 2.默认参数值
function greet(string $name,string $prefix = "Hi"): string {
    return $prefix.$name;
}
echo greet("jiang"),PHP_EOL;
echo greet("jiang","Hello"),PHP_EOL;

// 3.命名参数
echo greet(name: "Dengke",prefix: "Yo"),PHP_EOL;

/** 4) 可变参数（...）与数组展开 */
function sum(int ...$xs): int {return array_sum($xs);}
echo "sum = ", sum(1,2,3,4),PHP_EOL;
$nums = [5,6,7];
echo "sum2 = ", sum(...$nums),PHP_EOL;

/** 5) 返回多个值：数组 + 解构 */
function divmod(int $a,int $b): array{
    return [intdiv($a,$b), $a % $b];   // [商, 余数]
}
[$q,$r] = divmod(17,5);
echo "divmod => q=$q r=$r",PHP_EOL;