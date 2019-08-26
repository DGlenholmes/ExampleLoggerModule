<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Modules\Logger\Logger;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @throws \Exception
     */
    public function index()
    {
        return view('index');
    }

    /**
     * @throws \Exception
     */
    public function logsFromFile()
    {
        return view(
            'logs-from-file', [
                // Set an argument to filter. [ERROR, WARNING, INFO]
                // Default is null which returns all logs from all files
                'logs' => Logger::fetchLogsFromFileByType(),
            ]
        );
    }

    /**
     * @throws \Exception
     */
    public function logsFromDatabase()
    {
        return view(
            'logs-from-database', [
                // Set an argument to filter. [ERROR, WARNING, INFO]
                // Default is null which returns all logs from the database table
                'logs' => Logger::fetchLogsFromDatabaseByType('ERROR'),
            ]
        );
    }

    /**
     * @throws \Exception
     */
    public function log()
    {
        $logType = $_POST['logType'] ?? null;
        $logMessage = trim($_POST['logMessage']) ?? null;

        if (!empty($logMessage)) {
            switch ($logType) {
                case 'info':
                    Logger::info($logMessage);
                    break;
                case 'error':
                    Logger::error($logMessage);
                    break;
                case 'warning':
                    Logger::warning($logMessage);
                    break;
                default:
                    throw new \Exception("Invalid Logger Type Specified");
                    break;
            }
        }

        return redirect('/');
    }
}
