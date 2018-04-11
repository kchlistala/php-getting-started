<?php

pcntl_async_signals(true);

class Test
{
    private $exit = false;

    public function doLoop()
    {
	while (true) {
	    echo "loop\n";
	    file_get_contents("http://ovh.net/files/100Mb.dat");
            echo "xxx\n";
            if ($this->exit) {
                echo "bye\n";
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
