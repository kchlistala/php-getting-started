<?php

pcntl_async_signals(true);

class Test
{
    private $exit = false;

    public function doLoop()
    {
	while (true) {
	    echo "loop3\n";
	    sleep(30);
            echo "xxx3\n";
            if ($this->exit) {
                file_get_contents("http://ovh.net/files/1Gb.dat");
                echo "bye3\n";
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
