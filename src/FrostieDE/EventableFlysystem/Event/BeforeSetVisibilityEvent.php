<?php

namespace FrostieDE\EventableFlysystem\Event;

class BeforeSetVisibilityEvent extends BeforeFilesystemEvent {

    /** @var string */
    private $visibility;

    /**
     * @param string $path
     * @param string $visibility
     */
    public function __construct($path, $visibility) {
        parent::__construct($path);

        $this->visibility = $visibility;
    }

    /**
     * @return string
     */
    public function getVisibility() {
        return $this->visibility;
    }
}