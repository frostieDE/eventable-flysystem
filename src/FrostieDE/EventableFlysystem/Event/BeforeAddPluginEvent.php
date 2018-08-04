<?php

namespace FrostieDE\EventableFlysystem\Event;

use League\Flysystem\PluginInterface;

class BeforeAddPluginEvent extends BeforeFilesystemEvent {

    /** @var PluginInterface  */
    private $plugin;

    /**
     * @param PluginInterface $plugin
     */
    public function __construct(PluginInterface $plugin) {
        parent::__construct(null);

        $this->plugin = $plugin;
    }

    /**
     * @return PluginInterface
     */
    public function getPlugin() {
        return $this->plugin;
    }
}