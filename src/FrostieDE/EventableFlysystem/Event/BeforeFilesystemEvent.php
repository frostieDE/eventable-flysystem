<?php

namespace FrostieDE\EventableFlysystem\Event;

class BeforeFilesystemEvent extends FilesystemEvent {

    /** @var bool */
    private $cancel = false;

    public function cancel() {
        $this->cancel = true;
    }

    /**
     * @return bool
     */
    public function isCancelled() {
        return $this->cancel;
    }
}