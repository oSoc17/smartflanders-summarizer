<?php
namespace oSoc\Smartflanders\Filesystem;

class FileReader extends FileSystemProcessor {

    // Get the contents of a file and return a graph object
    public function getGraphsFromFile($filename) {
        // TODO
    }

    // Get the contents of a file
    private function getFileContents($filename) {
        if ($this->hasFile($filename)) {
            return $this->out_fs->read($filename);
        }
        return false;
    }
}
