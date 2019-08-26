<?php

namespace App\Modules\Logger;

interface LoggerInterface
{
    /**
     * @param string $message
     * @return mixed
     */
    public static function error(string $message);

    /**
     * @param string $message
     * @return mixed
     */
    public static function info(string $message);

    /**
     * @param string $message
     * @return mixed
     */
    public static function warning(string $message);

    /**
     * @param string $message
     * @param string $type
     * @return mixed
     */
    public static function writeLogToFile(string $message, string $type);

    /**
     * @param string $message
     * @param string $type
     * @return mixed
     */
    public static function writeLogToDatabase(string $message, string $type);

    /**
     * @param string $type
     * @return mixed
     */
    public static function fetchLogsFromFileByType(string $type = null);

    /**
     * @param string $type
     * @return mixed
     */
    public static function fetchLogsFromDatabaseByType(string $type = null);
}
