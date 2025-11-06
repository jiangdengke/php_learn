<?php
declare(strict_types=1);

/**
 * 场景：定义一个 Logger 规范（接口），
 *      两个实现（控制台/文件），
 *      用 Trait 复用“带时间戳”的小功能。
 */

/** 1) 接口：只规定“需要有哪些方法”，不写实现 */
interface Logger
{
    public function info(string $msg): void;
    public function error(string $msg): void;
}
/** 2) Trait：可被多个类 use 的“功能片段” */

trait TimeStamped {
    protected function now(): string {
        return date('Y-m-d H:i:s');
    }
}

/** 3) 实现一：控制台日志 */
class ConsoleLogger implements Logger
{
    use TimeStamped;

    public function info(string $msg): void {
        echo "[INFO ".$this->now()."] $msg".PHP_EOL;
    }
    public function error(string $msg): void {
        file_put_contents('php://stderr', "[ERROR ".$this->now()."] $msg".PHP_EOL, FILE_APPEND);
    }

}
/** 4) 实现二：文件日志 */
class FileLogger implements Logger {
    use TimeStamped;

    public function __construct(private string $path) {}

    public function info(string $msg): void {
        file_put_contents($this->path, "[INFO ".$this->now()."] $msg".PHP_EOL, FILE_APPEND);
    }
    public function error(string $msg): void {
        file_put_contents($this->path, "[ERROR ".$this->now()."] $msg".PHP_EOL, FILE_APPEND);
    }
}
/** 5) 依赖倒置：上层代码只认识“接口”，不关心具体实现 */
function runApp(Logger $logger): void{
    $logger->info("app started");

    $logger->error("oops, something went wrong");
    $logger->info("app finished");
}

$console = new ConsoleLogger();
runApp($console);

$file = new FileLogger(__DIR__ . '/app.log');
runApp($file);
echo "Wrote to the console log file." . PHP_EOL;