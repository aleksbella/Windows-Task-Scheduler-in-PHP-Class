<?php
namespace AleksBella\Scheduler;

date_default_timezone_set('Asia/Manila');

/*
//===============================================================
	 * @category  PHP, Command Line
	 * @author    Aleks Bella <aleksite@programmer.net>
	 * @copyright Copyright (c) 2023
	 * @license   http://opensource.org/licenses/gpl-3.0.html GNU Public License
	 * @link      https://github.com/aleksbella
	 * @version   1.4.0
//===============================================================
// 	 *  USE WITH YOUR OWN RISK
//===============================================================
*/

class Tasks {
    private const COMMAND = 'SCHTASKS';
    private static array $schTypes = ['minute', 'daily', 'hourly', 'monthly', 'weekly', 'once', 'onstart', 'onlogon', 'onidle'];
    private static array $outputTypes = ['default', 'live'];
    
    private string $outputType;
    private string $logFile;

    /**
     * Constructor to set output type and log file
     * @param string $outputType
     * @param string $logFile
     * @throws \Exception
     */
    public function __construct(string $outputType = 'default', string $logFile = 'scheduler.log') {
        if (!in_array($outputType, self::$outputTypes, true)) {
            throw new \Exception("Invalid output type");
        }
        $this->outputType = $outputType;
        $this->logFile = $logFile;
    }

    /**
     * Execute raw command
     * @param string $command
     * @return string|null
     */
    public function rawQuery(string $command): ?string {
        return empty($command) ? null : $this->execute($command);
    }

    /**
     * Schedule a task with given parameters
     * @param string $type
     * @param array $data
     * @return string
     * @throws \Exception
     */
    public function schedule(string $type, array $data): string {
        if (!isset($data['sc']) || !in_array($data['sc'], self::$schTypes, true)) {
            throw new \Exception('Invalid schedule! Use: ' . implode(", ", self::$schTypes));
        }

        $commandParts = [];
        foreach ($data as $key => $value) {
            $commandParts[] = is_int($key) ? '/' . strtoupper($value) : '/' . strtoupper($key) . ' "' . $value . '"';
        }

        $command = self::COMMAND . ' /' . strtoupper($type) . ' ' . implode(' ', $commandParts);
        $result = $this->execute($command);
        $this->logCommand($command, $result);
        return $result;
    }

    /**
     * Execute command based on output type
     * @param string $command
     * @return string
     */
    private function execute(string $command): string {
        $command = trim($command) . ' 2>&1';

        if ($this->outputType === 'live') {
            return $this->executeLive($command);
        }

        return shell_exec($command) ?: 'Execution failed';
    }

    /**
     * Execute command in live mode
     * @param string $command
     * @return string
     */
    private function executeLive(string $command): string {
        $handle = popen($command, 'r');
        if (!$handle) {
            return 'Failed to open process';
        }

        $output = '';
        while (!feof($handle)) {
            $output .= fread($handle, 4096);
            flush();
        }
        pclose($handle);

        return $output;
    }

    /**
     * Log executed commands
     * @param string $command
     * @param string $result
     * @return void
     */
    private function logCommand(string $command, string $result): void {
        $logEntry = sprintf("[%s] COMMAND: %s\nRESULT: %s\n\n", date('Y-m-d H:i:s'), $command, $result);
        file_put_contents($this->logFile, $logEntry, FILE_APPEND | LOCK_EX);
    }
}
