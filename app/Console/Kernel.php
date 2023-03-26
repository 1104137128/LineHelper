<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

use App\Models\PttScheduleModel;
class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();

        $schedule->call(function () {
            $headers = [
                'Content-Type: multipart/form-data',
                'Authorization: Bearer xRZOlmh1luuUQKLy6wFu633wBCiLsTMAjsuEZ5m8qpb'
            ];

            PttScheduleModel::get()->map(function($ptt) use($headers) {
                if (is_int(date('i') / $ptt->schedule_time) === false) return;

                $posts = shell_exec("python3 /var/www/html/PigFrog/ptt.py {$ptt->name} 2>&1");

                foreach (json_decode($posts) as $post) {
                    $message = ['message' => "{$ptt->name}文章: {$post}"];
                    $line_api_url = 'https://notify-api.line.me/api/notify';

                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_URL, $line_api_url);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $message);

                    $result = curl_exec($ch);
                    curl_close($ch);
                }
            });
        })->everyMinute();
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
