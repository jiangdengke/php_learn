<?php

declare(strict_types=1);

/**
 * 场景：做一个“形状”体系
 * - 抽象类 Shape 规定：必须能算 area()，能输出 describe()
 * - 子类 Rectangle、Circle 实现各自逻辑
 * - Square 继承 Rectangle，但用 final 锁住重写
 */
abstract class Shape
{
    public function __construct(protected string $name)
    {
    }

    /** 抽象方法：子类必须实现 */
    abstract public function area(): float;

    /** 共有实现：子类可直接复用或重写 */
    public function describe(): string
    {
        return "Shape: {$this->name}, area=" . $this->area();
    }
}

class Rectangle extends Shape
{
    public function __construct(private float $w, private float $h)
    {
        parent::__construct('Rectangle');
        if ($w <= 0 || $h <= 0) {
            throw new InvalidArgumentException('w/h must be > 0');
        }
    }

    public function area(): float
    {
        return $this->w * $this->h;
    }

    /** 重写（override）父类方法：加入更多信息 */
    public function describe(): string
    {
        return parent::describe() . " ({$this->w}x{$this->h})";
    }
}

/** 最终类：不允许再被继承（设计定型、避免被改坏） */
final class Square extends Rectangle
{
    public function __construct(float $side)
    {
        // 正方形是特殊的长方形（w=h）
        parent::__construct($side, $side);
        // 注意：这里不需要改 area()，复用父类逻辑
    }
}

class Circle extends Shape
{
    public function __construct(private float $r)
    {
        parent::__construct('Circle');
        if ($r <= 0) {
            throw new InvalidArgumentException('r must be > 0');
        }
    }

    public function area(): float
    {
        return M_PI * $this->r * $this->r;
    }
}

/** 多态：接收 Shape，实参可以是任何子类 */
function printInfo(Shape $s): void
{
    echo $s->describe(), PHP_EOL;
}

// ===== 演示 =====
$rect = new Rectangle(3, 4);
$sq = new Square(5);
$cir = new Circle(2);

printInfo($rect); // 调用 Rectangle::describe() / area()
printInfo($sq);   // 复用 Rectangle 逻辑
printInfo($cir);  // 调用 Circle::area()

// 取消注释看看异常与 final 行为
// class BadSquare extends Square {} // ❌ Fatal: Final class cannot be extended
// $bad = new Rectangle(-1, 2);     // ❌ InvalidArgumentException
