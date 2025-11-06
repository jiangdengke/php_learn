<?php
declare(strict_types=1);
/**
 * User 类：演示
 * - 构造器属性提升（PHP 8+）
 * - 可见性：public / private / protected
 * - 方法中的 $this
 * - 基本的输入校验 + 抛异常
 */
class User
{
    // 构造器属性提升：在构造函数参数处直接定义并赋值给属性
    public function __construct(
        private string $name,
        private int $age
    ){
        $this->name = trim($this->name);
        $this->assertValidAge($age);
    }
    // 对外只读：提供 getter（先别写 setter，演示“封装”）
    public function getName(): string {return $this->name;}
    public function getAge(): int {return $this->age;}

    // 行为方法：过生日
    public function birthday(): void
    {
        $this->age++;
    }

    // 行为方法：改名（带简单校验）
    public function rename(string $newName): void
    {
        $newName = trim($newName);
        if ($newName === '') {
            throw new InvalidArgumentException('Name cannot be empty');
        }
        $this->name = $newName;
    }

    // 私有的校验工具方法(外部不可直接调用)
    private function assertValidAge(int $age): void
    {
        if ($age < 0 || $age > 150) {
            throw new InvalidArgumentException('invalid age:'.$age);
        }
    }
}

$user = new User('jiang',20);
echo $user->getName(),PHP_EOL;
echo $user->getAge(),PHP_EOL;

$user->birthday();
echo $user->getAge(),PHP_EOL;

$user->rename('dengke');
echo $user->getName(), PHP_EOL;

// 取消注释看看异常（演示校验）
 $bad = new User('Jack', -3);         // InvalidArgumentException
 $user->rename('   ');                // InvalidArgumentException