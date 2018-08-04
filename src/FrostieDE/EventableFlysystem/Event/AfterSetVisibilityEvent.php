<?php

namespace FrostieDE\EventableFlysystem\Event;

class AfterSetVisibilityEvent extends AfterFilesystemEvent {

    /** @var string */
    private $visibility;

    /**
     * AfterSetVisibilityEvent constructor.
     * @param string $path
     * @param string $visibility
     * @param mixed $result
     */
    public function __construct($path, $visibility, $result) {
        parent::__construct($path, $result);

        $this->visibility = $visibility;
    }

    /**
     * @return string
     */
    public function getVisibility() {
        return $this->visibility;
    }
}