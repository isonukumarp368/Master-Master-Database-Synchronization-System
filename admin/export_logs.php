$log = file_get_contents("../logs/sync.log");
header("Content-Disposition: attachment; filename=sync_log.txt");
header("Content-Type: text/plain");
echo $log;