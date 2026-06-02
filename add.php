<?php
header("Content-Type: text/html; charset=utf-8");

function get_real_ip(){
    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ips = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
        return trim($ips[0]);
    }
    return $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
}

$reip = get_real_ip();

$who     = $_REQUEST["who"] ?? '';
$status  = $_REQUEST[$who."_status"] ?? '';
$input   = $_REQUEST[$who."_input"] ?? '';
$v       = $_REQUEST["v"] ?? '';

$file = __DIR__ . "/lst.txt";

$status_dict = [
    "0"=>"起床囉!",
    "1"=>"準備午餐中!",
    "2"=>"出門去!",
    "3"=>"工作中!",
    "4"=>"吃晚餐!",
    "5"=>"洗澡中!",
    "6"=>"愛睏中!",
    "7"=>"其他!"
];

// 清空 input
echo "<script>
parent.document.querySelector('#{$who}_send_input').value='';
</script>";

// 建檔
if (!file_exists($file)) {
    file_put_contents($file, "{}");
}

// 讀 JSON + 去 BOM
$json = file_get_contents($file);
$json = preg_replace('/^\xEF\xBB\xBF/', '', $json);

$vc = json_decode($json, true);
if (!is_array($vc)) $vc = [];

/*
--------------------------------------------------
防重複（取代 Python 那段）
--------------------------------------------------
*/
$last = end($vc);

if ($last &&
    $last['who'] === $who &&
    $last['who_status'] === $status &&
    $last['who_input'] === $input
) {
    $last_time = strtotime($last['who_time']);
    $now = time();

    if (($now - $last_time) < 10) {
        echo "<script>
            alert('不要調皮，連續按太多次!!!');
        </script>";
        exit;
    }
}

/*
--------------------------------------------------
新增資料
--------------------------------------------------
*/
$index = !empty($vc) ? (max(array_keys($vc)) + 1) : 1;
$now_time = date("Y-m-d H:i:s");
$vc[$index] = [
    "who_status" => $status,
    "who_input"  => $input,
    "who_ip"     => $reip,
    "who_time"   => $now_time,
    "who"        => $who
];

/*
--------------------------------------------------
寫回 JSON
--------------------------------------------------
*/
file_put_contents(
    $file,
    json_encode($vc, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)
);
// -----------------------------
// kiki 特殊處理
// -----------------------------
if ($who == "kiki") {
    if ($status != "7") {
        $input = $status_dict[$status] ?? $who_input;
    }
    $message = $who . "說:" . $input;
    // 寫 log（取代 kiki.txt）
    $line = $now_time . "," . $input . "\n";
    file_put_contents("./kiki.txt", $line, FILE_APPEND);

    // Discord webhook
    file_get_contents(
        "https://author.lugeshop.com/discord.php?message=" . urlencode($message) . "&channel=note"
    );

    // LINE webhook
    file_get_contents(
        "https://author.lugeshop.com/linev2.php?message=" . urlencode($message)
    );
}
echo "OK";
?>
