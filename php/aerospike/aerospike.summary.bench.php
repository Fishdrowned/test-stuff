<pre>
<?php
$log_path = '/data/vdc/bench/nginx-rw-concurrent.log';
$lines = explode("\n", file_get_contents($log_path));
$writes = 0;
$writes_fail = 0;
$reads = 0;
$reads_fail = 0;
$total = 0;
$runtime = 0;
$max_runtime = 0;
$begins = 0;
$ends = 1;
$concurrents = 0;
foreach ($lines as $line) {
    $line = trim($line);
    if ($line == '') continue;
//    list($l_pid, $l_total, $l_runtime, $l_tps, $l_reads, $l_reads_failed, $l_writes, $l_writes_failed) = explode("|", $line);
    list($l_pid, $l_total, $l_runtime, $l_tps, $l_reads, $l_reads_failed, $l_writes, $l_writes_failed, $l_begins, $l_ends) = explode("|", $line);
    $total += $l_total;
    $runtime += $l_runtime;
    $writes += $l_writes;
    $writes_fail += $l_writes_failed;
    $reads += $l_reads;
    $reads_fail += $l_reads_failed;
    if ($l_runtime > $max_runtime) $max_runtime = $l_runtime;
    $l_begins > 0 && ($begins == 0 || $l_begins < $begins) and $begins = $l_begins;
    $l_ends > $ends and $ends = $l_ends;
    ++$concurrents;
}

$avg_runtime = $runtime / $concurrents;
$write_success = $writes ? (($writes - $writes_fail) / $writes) * 100 : 0;
$read_success = $reads ? (($reads - $reads_fail) / $reads) * 100 : 0;
$tps = $runtime ? $total / $runtime : 0;
$combined_tps = $runtime ? $total / $max_runtime : 0;
$actual_runtime = $ends - $begins;
$actual_tps = $total / $actual_runtime;
$actual_rps = count($lines) / $actual_runtime;
echo "Writes: $writes with $writes_fail failed ($write_success% success)\n";
echo "Reads: $reads with $reads_fail failed ($read_success% success)\n";
echo "Max runtime: {$max_runtime}s, average runtime: {$avg_runtime} total runtime: {$runtime}s\n";
echo "$total transactions executed at average {$tps}tps per-process, combined to {$combined_tps}tps\n";
echo "Actual runtime: {$actual_runtime}s, actual tps: {$actual_tps}, actual rps: {$actual_rps}rps\n";

