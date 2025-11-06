<?php
declare(strict_types=1);

/**
 * 两种枚举：
 * - 纯枚举（Pure Enum）：只有“成员”，没有底层值
 * - 标量枚举（Backed Enum）：每个成员绑定一个 string/int 值，可 from()/tryFrom()
 */
/** 1) 纯枚举：适合只表示“状态”的场景 */
enum Role{
    case Guest;
    case User;
    case Admin;

    // 可以给枚举写方法
    public function canManageUsers(): bool {
        return match ($this) {
            self::Admin => true,
            self::User, self::Guest => false, // 同一个分支里用逗号写多个“标签”
        };
    }
}
$r = Role::Admin;
var_dump($r->canManageUsers());

/** 2) 标量枚举（string/int） */
enum OrderStatus: string
{
    case Pending = 'pending';
    case Paid = 'paid';
    case Cancel = 'cancel';

    public function label(): string
    {
        return match ($this) {
            self::Pending => '待支付',
            self::Paid    => '已支付',
            self::Cancel  => '已取消'
        };
    }
    public function canRefund(): bool
    {
        return $this === self::Paid;
    }
}
// 2.1 创建/比较
$st = OrderStatus::Paid;
echo $st->label(), PHP_EOL;
var_dump($st === OrderStatus::Paid);

// 2.2 和外部数据互转（from/tryFrom 只在 Backed Enum 上有）
$st2 = OrderStatus::from('pending'); // 找不到会抛 ValueError
echo $st2->label(), PHP_EOL;

$maybe = OrderStatus::tryFrom('oops');  // 找不到返回 null（更安全）
var_dump($maybe);

// 2.3 序列化/存储：存 value，而不是对象本身
echo "to db: ",$st->value,PHP_EOL;

// 2.4 遍历所有枚举成员
foreach (OrderStatus::cases() as $case)
{
    echo $case->name, ' => ',$case->value, PHP_EOL;
}

/** 3) 在类中使用枚举（更安全的状态机） */
final class Order
{
    public function __construct(
        public string $id,
        public OrderStatus $status = OrderStatus::Pending
    ){}

    public function pay(): void {
        if ($this->status === OrderStatus::Pending) {
            throw new LogicException("只能从pengding支付");
        }
        $this->status = OrderStatus::Paid;
    }
    public function cancel(): void{
        if ($this->status === OrderStatus::Paid){
            throw new LogicException("已支付订单不能取消");
        }
        $this->status = OrderStatus::Cancel;
    }
}

$o = new Order("A001");
echo "init=",$o->status->value,PHP_EOL;
echo "aaaaa";
$o->pay();
echo "after pay=",$o->status->value,PHP_EOL;


