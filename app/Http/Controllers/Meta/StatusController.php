<?php

declare(strict_types=1);

namespace App\Http\Controllers\Meta;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class StatusController extends Controller
{
    public function index()
    {
        try {
            DB::connection()->getPdo()->query('SELECT 1');
            DB::connection()->getPdo()->exec('SET @test_write = 1');
            $dbStatus = 'OK';
        } catch (\Exception $e) {
            $dbStatus = 'Erro: ' . $e->getMessage();
        }

        $lastCronExecution = Redis::get('cron_last_execution');
        $uptime = trim(shell_exec('uptime -p'));
        $memoryUsageMB = round(memory_get_usage(true) / 1024 / 1024, 2);
        $memoryLimit = ini_get('memory_limit');

        return response()->json([
            'database_status' => $dbStatus,
            'last_cron_execution' => $lastCronExecution,
            'uptime' => $uptime,
            'memory_usage_mb' => $memoryUsageMB,
            'memory_limit' => $memoryLimit,
        ]);
    }
}
