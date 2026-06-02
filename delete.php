<?php
header("Content-Type: text/html; charset=utf-8");

$file = __DIR__ . "/lst.txt";

$who = $_GET['who'] ?? '';
$id  = $_GET['status_id'] ?? '';
$v   = $_GET['v'] ?? '';

// 基本防呆
if ($id === '' || !file_exists($file)) {
    exit("invalid request");
}

// 讀 JSON
$json = file_get_contents($file);

// 去 BOM（你前面已經踩過）
$json = preg_replace('/^\xEF\xBB\xBF/', '', $json);

$data = json_decode($json, true);

if (!is_array($data)) {
    $data = [];
}
$target = $data[$id] ?? null;
// -----------------------------
// 2. 如果有圖片 → 刪檔案
// -----------------------------
if ($target && isset($target['who_input'])) {

    $html = $target['who_input'];

    // 抓 src="..."
    if (preg_match('/src=["\'](.*?)["\']/', $html, $m)) {

        $imgPath = $m[1];
        $imgPath = ltrim($imgPath, './');
        // 只允許刪 /upload/
        if (strpos($imgPath, 'upload/') !== false) {

             $realPath = __DIR__ . '/' . $imgPath;

            if (file_exists($realPath)) {
                unlink($realPath);
            }else {
                echo "FILE NOT FOUND: $realPath";
            }
        }
    }
}
// 刪除資料
if (isset($data[$id])) {
    unset($data[$id]);
}

// 重新排序 key（可選）
$data = array_values($data);
$new = [];

foreach ($data as $k => $vdata) {
    $new[$k + 1] = $vdata;
}

// 寫回檔案
file_put_contents(
    $file,
    json_encode($new, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)
);

// 回到列表
//header("Location: search.php");
exit;
