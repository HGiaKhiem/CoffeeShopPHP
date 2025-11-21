<?php
// tools/inspect_mon_duplicates.php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

echo "TOTAL: " . DB::table('Mon')->count() . PHP_EOL;
echo "DISTINCT: " . DB::table('Mon')->distinct()->count('TenMon') . PHP_EOL;
$rows = DB::select("SELECT TenMon, GROUP_CONCAT(ID_Mon) AS ids, COUNT(*) AS c FROM Mon GROUP BY TenMon HAVING c>1 ORDER BY TenMon");
if (empty($rows)) {
    echo "No duplicates found.\n";
} else {
    echo "Duplicates:\n";
    foreach ($rows as $r) {
        echo $r->TenMon . ' -> ' . $r->c . ' (ids: ' . $r->ids . ')\n';
    }
}
