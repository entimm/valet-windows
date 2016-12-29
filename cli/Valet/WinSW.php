<?php

namespace Valet;

class WinSW
{
    var $cli, $files;

    /**
     * Create a new WinSW instance.
     *
     * @param  CommandLine  $cli
     * @param  Filesystem  $files
     */
    public function __construct(CommandLine $cli, Filesystem $files)
    {
        $this->cli = $cli;
        $this->files = $files;
    }

    /**
     * Install a Windows service.
     *
     * @param  string $service
     * @param  array  $args
     * @return void
     */
    public function install($service, $args = [])
    {
        $args['VALET_HOME_PATH'] = VALET_HOME_PATH;

        $contents = $this->files->get(__DIR__."/../stubs/$service.xml");

        $this->files->putAsUser(
            VALET_HOME_PATH."/Services/$service.xml",
            str_replace(array_keys($args), array_values($args), $contents)
        );

        $binPath = realpath(__DIR__.'/../../bin');

        $this->files->copy("$binPath/winsw.exe", VALET_HOME_PATH."/Services/$service.exe");

        $command = 'cmd "/C cd '.VALET_HOME_PATH.'\Services && '.$service.' install"';

        $this->cli->runOrDie($command, function ($code, $output) {
            warning($output);
        });
    }

    /**
     * Uninstall a Windows service.
     *
     * @param  string $service
     * @return void
     */
    public function uninstall($service)
    {
        $this->stop($service);

        $this->cli->quietly('cmd "/C cd '.VALET_HOME_PATH.'\Services && '.$service.' uninstall"');

        // $this->files->unlink(VALET_HOME_PATH."/Services/$service.exe");
        // $this->files->unlink(VALET_HOME_PATH."/Services/$service.xml");
    }

    /**
     * Restart a Windows service.
     *
     * @param  string $service
     * @return void
     */
    public function restart($service)
    {
        $this->stop($service);

        $command = 'cmd "/C cd '.VALET_HOME_PATH.'\Services && '.$service.' start"';

        $this->cli->runOrDie($command, function ($code, $output) {
            warning($output);
        });
    }

    /**
     * Stop a Windows service.
     *
     * @param  string $service
     * @return void
     */
    public function stop($service)
    {
        $this->cli->quietly('cmd "/C cd '.VALET_HOME_PATH.'\Services && '.$service.' stop"');
    }
}
