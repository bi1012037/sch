<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: text/html; charset=UTF-8');

function get_real_ip(){
    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ips = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
        return trim($ips[0]);
    }
    return $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
}

echo "<pre>";
echo "=== DEBUG START ===\n";

// -----------------------------
// 1. 檢查檔案
// -----------------------------
if (!isset($_FILES['my_file'])) {
    die("❌ NO FILE\n");
}

$file = $_FILES['my_file'];

if ($file['error'] !== UPLOAD_ERR_OK) {
    die("❌ UPLOAD ERROR: ".$file['error']."\n");
}

// -----------------------------
// 2. move upload
// -----------------------------
//$dir = __DIR__ . '/upload/' . date("Ymd") . '/';
$dir = './upload/' . date("Ymd") . '/';

if (!is_dir($dir)) {
    mkdir($dir, 0777, true);
}

$ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
if ($ext == "jpeg") $ext = "jpg";

$filename = time() . "." . $ext;
$dest = $dir . $filename;

if (!move_uploaded_file($file['tmp_name'], $dest)) {
    die("❌ MOVE FAILED\n");
}

// -----------------------------
// 3. 取資料
// -----------------------------
$file_json = __DIR__ . "/lst.txt";

if (!file_exists($file_json)) {
    file_put_contents($file_json, "{}");
}

$json = file_get_contents($file_json);
$json = preg_replace('/^\xEF\xBB\xBF/', '', $json);

$data = json_decode($json, true);
if (!is_array($data)) $data = [];

// -----------------------------
// 4. IP / who
// -----------------------------
$reip = get_real_ip();

$who = $_REQUEST["who"] ?? "unknown";
$v   = $_REQUEST["v"] ?? "";
$status = "7";

// -----------------------------
// 5. 防重複（取代 Python 邏輯）
// -----------------------------
$last = end($data);
$who_input = "圖片上傳<br><img style='width:100%' src='$dest'>";

if ($last &&
    $last['who'] === $who &&
    $last['who_status'] === $status &&
    $last['who_input'] === $who_input
) {
    $last_time = strtotime($last['who_time']);
    if (time() - $last_time < 10) {
        echo "❌ 太快重複\n";
        exit;
    }
}

// -----------------------------
// 6. 寫入資料
// -----------------------------
$index = !empty($data) ? (max(array_keys($data)) + 1) : 1;

$data[$index] = [
    "who_status" => $status,
    "who_input"  => $who_input,
    "who_ip"     => $reip,
    "who_time"   => date("Y-m-d H:i:s"),
    "who"        => $who
];

// -----------------------------
// 7. 存檔
// -----------------------------
file_put_contents(
    $file_json,
    json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)
);

// -----------------------------
// 8. 回傳
// -----------------------------
echo "✔ OK\n";
echo "FILE: $dest\n";
echo "WHO: $who\n";

echo "=== DEBUG END ===";
echo "</pre>";

?>
