<?php

namespace FrostieDE\EventableFlysystem\Event;

class AfterFilesystemEvent extends FilesystemEvent {

    /** @var mixed */
    private $result;

    /**
     * @param string $path
     * @param mixed $result
     */
    public function __construct($path, $result) {
        parent::__construct($path);

        $this->result = $result;
    }

    /**
     * @return mixed
     */
    public function getResult() {
        return $this->result;
    }
}