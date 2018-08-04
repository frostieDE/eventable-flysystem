<?php

namespace FrostieDE\EventableFlysystem\Event;

use League\Flysystem\PluginInterface;

class AfterAddPluginEvent extends AfterFilesystemEvent {

    /** @var PluginInterface  */
    private $plugin;

    /**
     * @param PluginInterface $plugin
     */
    public function __construct(PluginInterface $plugin) {
        parent::__construct(null, null);

        $this->plugin = $plugin;
    }

    /**
     * @return PluginInterface
     */
    public function getPlugin() {
        return $this->plugin;
    }
}