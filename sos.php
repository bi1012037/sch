<?php
$command = 'ssh linchingyen@125.228.205.164 "python E:\sch\sos.py" > /dev/null 2>&1 &';
$output = shell_exec($command);
echo $output;
echo "<script>parent.document.getElementById('myframe').src = '';</script>";
?>
