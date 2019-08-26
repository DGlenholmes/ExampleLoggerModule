<?php

namespace App\Modules\Logger;

use App\Log;

/**
 * Class Logger
 * @package App\Modules\Logger
 *
 * This logger can be utilised abstractly to add logs of a specified type
 * to either a database table (created via migration by running php artisan
 * migrate) or to simple text files (separated by type in the public/logs
 * folder.
 *
 * Each of the 3 implemented log type functions hit the writeLog() method which
 * checks the $logStorage to decide on the desired storage medium. If it's
 * not one of the two options, it stores in both database and file mediums.
 * I wasn't really sure which of the database or filesystem was a more preferable
 * method for the test so wanted to demonstrate the capability for both.
 *
 * The retrieval functions have been done to demonstrate the capability of
 * flexible returns meaning that if a type filter is specified then only
 * logs of that type will be returned to wherever the function is called
 * (in this case, that's in the generic Controller class) and if there is
 * no type argument passed then all the logs will be fetched, compiled and
 * returned as an array.
 */
class Logger implements LoggerInterface
{
    protected static $logStorage = 'file';

    /**
     * @param string $message
     * @param string $type
     * @throws \Exception
     * @return void
     */
    public static function error(string $message, string $type = 'ERROR'): void
    {
        self::writeLog($message, $type);
    }

    /**
     * @param string $message
     * @param string $type
     * @throws \Exception
     * @return void
     */
    public static function info(string $message, string $type = 'INFO'): void
    {
        self::writeLog($message, $type);
    }

    /**
     * @param string $message
     * @param string $type
     * @throws \Exception
     * @return void
     */
    public static function warning(string $message, string $type = 'WARNING'): void
    {
        self::writeLog($message, $type);
    }

    /**
     * @param $message
     * @param $type
     * @throws \Exception
     * @return void
     */
    private static function writeLog(string $message, string $type): void
    {
        if (self::$logStorage === 'database') {
            self::writeLogToDatabase($message, $type);
        } elseif (self::$logStorage === 'file') {
            self::writeLogToFile($message, $type);
        } else {
            self::writeLogToDatabase($message, $type);
            self::writeLogToFile($message, $type);
        }
    }

    /**
     * @param $message
     * @param $type
     * @throws \Exception
     * @return void
     */
    public static function writeLogToFile(string $message, string $type): void
    {
        $filepath = "logs/" . strtolower($type) . "_log.txt";

        if(!file_exists("{$filepath}")) {
            fopen("{$filepath}", 'w') or exit("Unable to create file {$filepath}");
        }

        if (!is_writable("{$filepath}")) {
            throw new \Exception("File '{$filepath}' is not writeable");
        } else {
            $logFile = fopen("{$filepath}", "a");
        }

        $timestamp = date("Y-m-d h:i:s", strtotime("NOW"));
        $ipAddress = $_SERVER['REMOTE_ADDR'];

        /**
         * Storing log line as JSON to give the read function a more consistent method
         * or breaking down the sections over something like array parts.
         */
        $log = '[{"type":"'.$type.'","message":"'.$message.'","ipAddress":"'.$ipAddress.'","timestamp":"'.$timestamp.'"}]'.PHP_EOL;

        fwrite($logFile, $log);
    }

    /**
     * @param $message
     * @param $type
     * @return void
     */
    public static function writeLogToDatabase(string $message, string $type): void
    {
        // Using eloquents Active Directory/ORM
        $log = new Log();
        $log->message = $message;
        $log->type = $type;
        $log->ip_address = $_SERVER['REMOTE_ADDR'] ?? null;
        $log->save();
    }

    /**
     * @param string $type
     * @return array
     */
    public static function fetchLogsFromFileByType(string $type = null): array
    {
        $logs = [];
        $files = [];
        $fileLines = [];

        /**
         * Most of this is probably overkill but wanted to ensure that
         * if an argument wasn't given, the logs would still all be shown
         */
        if ($type) {
            $files[] = "logs/".strtolower($type)."_log.txt";
        } else {
            foreach (scandir("logs") as $file) {
                $files[] = "logs/".$file;
            }
        }

        foreach ($files as $file) {
            foreach (file($file) as $fileLine) {
                $fileLines[] = $fileLine;
            }
        }

        foreach ($fileLines as $line) {
            $lineArray = json_decode(trim($line), true);

            $log = [];
            $log['message'] = $lineArray[0]['message'];
            $log['type'] = $lineArray[0]['type'];
            $log['ip_address'] = $lineArray[0]['ipAddress'];
            $log['created_at'] = $lineArray[0]['timestamp'];

            $logs[] = $log;
        }

        return $logs;
    }

    /**
     * @param string $type
     * @return array
     */
    public static function fetchLogsFromDatabaseByType(string $type = null): array
    {
        $logs = Log::orderBy('created_at', 'DESC')->get()->toArray();

        if ($type) {
            return array_filter($logs, function ($log) use ($type) {
                return $log['type'] === $type;
            });
        } else {
            return $logs;
        }
    }
}
