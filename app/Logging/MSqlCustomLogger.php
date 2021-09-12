<?php
namespace App\Logging;

use Monolog\Logger;

class MSqlCustomLogger {
    /**
     * Create a custom Monolog instance.
     *
     *
     * @param  array  $config
     * @return Logger
     */
    public function __invoke(array $config): Logger
    {
        $logger = new Logger("MySQLLoggingHandler");
        return $logger->pushHandler(new MSqlLoggingHandler());
    }
}
