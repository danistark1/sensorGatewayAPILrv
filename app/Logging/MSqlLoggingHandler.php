<?php

namespace App\Logging;
// use Illuminate\Log\Logger;
use Database;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Monolog\Logger;
use Monolog\Handler\AbstractProcessingHandler;

class MSqlLoggingHandler extends AbstractProcessingHandler
{
    /**
     *
     * Reference:
     * https://github.com/markhilton/monolog-mysql/blob/master/src/Logger/Monolog/Handler/MysqlHandler.php
     */
    public function __construct($level = Logger::DEBUG, $bubble = true)
    {
        $this->table = 'sensor_Logs';
        parent::__construct($level, $bubble);
    }

    protected function write(array $record): void
    {
        $data = array(
            'message' => $record['message'],
            'context' => json_encode($record['context']),
            'level' => $record['level'],
            'level_name' => $record['level_name'],
            'channel' => $record['channel'],
            'record_datetime' => $record['datetime']->format('Y-m-d H:i:s'),
            'extra' => json_encode($record['extra']) ?? null,
            'remote_address' => $_SERVER['REMOTE_ADDR'] ?? null,
            'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? null,
            'created_at' => date("Y-m-d H:i:s")
        );

        DB::connection()->table($this->table)->insert($data);
    }
}
