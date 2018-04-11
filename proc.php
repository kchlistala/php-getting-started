<?php

pcntl_async_signals(true);

class Test
{
    private $exit = false;

    public function doLoop()
    {
	while (true) {
	    echo "loop2\n";
	    sleep(30);
            echo "xxx2\n";
            if ($this->exit) {
                sleep(10);
                echo "bye2\n";
                exit;
            }
	}
    }

    public function sigHandler($sig)
    {
        $this->exit = true;
    }
}

$test = new Test();

pcntl_signal(SIGTERM, [$test, "sigHandler"]);
pcntl_signal(SIGHUP,  [$test, "sigHandler"]);
pcntl_signal(SIGUSR1, [$test, "sigHandler"]);

$test->doLoop();
