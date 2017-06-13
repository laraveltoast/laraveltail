<?php

namespace laraveltoast\laraveltail;

use Exception;
use Illuminate\Console\Command;
use Symfony\Component\Process\Process;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class LaravelTailCommand extends Command {

    /**
     * The console command name.
     * @author Suraj Mishra <suraj.mishra@sterlite.com>
     * @var string
     */
    protected $name = 'tailLog';

    /**
     * Create a new command instance.
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Execute the console command.
     * @return mixed
     * @throws Exception
     */
    public function fire() {
        $this->tailLogFile();
    }

    /**
     * Tail the latest local log file.
     * @author Suraj Mishra <suraj.mishra@sterlite.com>
     * @return null|string
     */
    private function tailLogFile() {
        $path = $this->findLogfile();
        $this->info('start Loging on Path ' . $path);
        $Command = 'tail -f ' . escapeshellarg($path);
        $this->exeCommand($Command);
        return $path;
    }

    /**
     * Execute the given command.
     * @author Suraj Mishra <suraj.mishra@sterlite.com>
     * @param string $command
     */
    protected function exeCommand($command) {
        $output = $this->output;
        (new Process($command))->setTimeout(null)->run(function ($type, $line) use ($output) {
            $output->write($line);
        });
    }

    /**
     * Get the path to the latest local Laravel log file.
     * @author Suraj Mishra <suraj.mishra@sterlite.com>
     * @return null|string
     */
    public static function findLogfile() {
        $files = glob(storage_path('logs') . '/*.log');
        $files = array_combine($files, array_map('filemtime', $files));
        arsort($files);
        $latestLogFile = key($files);
        return $latestLogFile;
    }

}
