<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Http;

use App\Models\PttScheduleModel;
use App\Models\StockScheduleModel;
class Kernel extends ConsoleKernel
{

    private $headers = [
        'Content-Type: multipart/form-data',
        'Authorization: Bearer 66sPQxfXIL6qT3340pwIz6ULNEqZ6iS5qg9QGUL2xqc'
    ];

    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();

        $schedule->call(function () {
            PttScheduleModel::get()->map(function($ptt) {
                if (is_int(date('i') / $ptt->schedule_time) === false) return;

                $posts = shell_exec("python3 /var/www/html/PigFrog/spider.py {$ptt->name} 2>&1");

                foreach (json_decode($posts) as $post) {
                    $message = ['message' => "{$ptt->name}文章: {$post}"];
                    $line_api_url = 'https://notify-api.line.me/api/notify';

                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_URL, $line_api_url);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $message);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);

                    $result = curl_exec($ch);
                    curl_close($ch);
                }
            });
        })->everyMinute();

        $schedule->call(function () {

            $stock = "";
            foreach(StockScheduleModel::get() as $value) {
                $stock .= "tse_{$value->name}.tw|";
            }

            $response = Http::get('https://mis.twse.com.tw/stock/api/getStockInfo.jsp', [
                'json' => '1', 'delay' => '0', 'ex_ch' => $stock,
            ]);

            $res = $response->json();
            foreach ($res['msgArray'] ?? [] as $value) {
                $price = (float) $value['z'];
                $message = ['message' => "{$value['n']}: \${$price}"];

                $line_api_url = 'https://notify-api.line.me/api/notify';

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_URL, $line_api_url);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $message);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);

                $result = curl_exec($ch);
                curl_close($ch);
            }
        })->weekdays()->twiceDaily(14, 19);
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
