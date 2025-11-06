<?php
declare(strict_types=1);
// 小工具：安全输出（防 XSS）
/**
 * htmlspecialchars($s, ENT_QUOTES, 'UTF-8') 会把 特殊字符 转成 HTML 实体：
 * &→&amp;，<→&lt;，>→&gt;，"→&quot;，'→&#039;（因为用了 ENT_QUOTES）。
 *
 * 'UTF-8' 指定按 UTF-8 解析字符串，避免乱码和安全问题。
 *
 * 结果：浏览器会显示这些符号，而不会把它们当成 HTML/脚本执行。
 */
function e(string $s): string
{
    return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}

/** 1) 读取 GET 参数 */
$name = $_GET['name'] ?? 'guest'; // 没传就给默认
echo "<h1>Hello," . e($name) . "</h1>";

/** 2) 处理 POST 表单 */
if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
    $msg = trim((string)($_POST['msg'] ?? ''));
    if ($msg === '') {
        echo "<p style='color:red'>Message required</p>";
    }else{
        // 先输出
        echo "<p>POST: " . e($msg) . "<p>";
    }
}
// 简单表单（提交到自己）
?>
<form method="post">
    <input name="msg" placeholder="say something">
    <button>Send</button>
</form>

<hr>
<p>Try: <a href="/?name=jiang">/?name=jiang</a></p>