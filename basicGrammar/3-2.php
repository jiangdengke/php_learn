<?php
declare(strict_types=1);

/** 1) 自定义异常类型（更好区分错误场景） */
class InvalidAmount extends RuntimeException {}
class DivideByZeroApp extends RuntimeException {}

/** 2) 带输入校验的函数：遇非法输入就抛异常 */
function pay(int $amount): void{
    if ($amount <= 0){
        throw new InvalidAmount("Amount must be greater than 0");
    }
    echo "Paid $amount".PHP_EOL;
}
function safe_divide(float $a, float $b): float{
    if ($b == 0.0) {
        throw new DivideByZeroApp("b must not be zero");
    }
    return $a / $b;
}


/** 3) try/catch/finally：捕获 & 收尾 */

try {
    pay(100);
    pay(0);
}catch (InvalidAmount $e) {
    echo "[Pay Error]",$e->getMessage(),PHP_EOL;
} finally {
    echo "finally: cleanup here".PHP_EOL;
}

try {
    echo "div = ",safe_divide(10,2),PHP_EOL;
    echo "div = ",safe_divide(1,0),PHP_EOL;
}catch (InvalidAmount $e) {
    echo "[Pay Error]",$e->getMessage(),PHP_EOL;
}