<?php
declare(strict_types=1);

/** 1) 写入与追加：file_put_contents */
$path = __DIR__.'/notes.txt';
file_put_contents($path,"first line".PHP_EOL); // 覆盖写
file_put_contents($path,"append line".PHP_EOL,FILE_APPEND); // 追加
echo "wrote：$path",PHP_EOL;

/** 2) 读取：file_get_contents（加上存在性判断更稳） */
if (!is_file($path)){
    throw new RuntimeException("file missing: $path");
}
$content = file_get_contents($path);
echo "---content---",PHP_EOL,$content,PHP_EOL;

/** 3) JSON 写入：json_encode（加选项，中文更友好） */
$data = ['id' => 1, 'name' => 'Jiang', 'tags' => ['php','基础'], 'vip' => true];
$jsonPath = __DIR__.'/data.json';
file_put_contents($jsonPath,json_encode($data,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
echo "Wrote JSON: $jsonPath",PHP_EOL;

/** 4) JSON 读取：json_decode + JSON_THROW_ON_ERROR（推荐） */
try {
    $raw = file_get_contents($jsonPath);
    if ($raw === false){
        throw new RuntimeException("read failed: $jsonPath");
    }
    try {
        $decoded = json_decode($raw, true, flags: JSON_THROW_ON_ERROR);
    } catch (JsonException $e) {
        echo $e->getMessage();
    }
    print_r($decoded);
}catch (JsonException $e){
    echo "[JSON Error]",PHP_EOL,$e->getMessage(),PHP_EOL;
}
/** 5) 安全细节：路径与目录 */
$dir = __DIR__.'out';
if (!is_dir($dir) && !mkdir($dir, 0777, true) && !is_dir($dir)){
    throw new RuntimeException("mkdir failed: $dir");
}

file_put_contents($dir.'/hello.txt','hello' . PHP_EOL);
echo "created ", $dir . 'hello.txt'.PHP_EOL;