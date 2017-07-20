<?php
namespace oSoc\Summary\Filesystem;

class FileReader extends FileSystemProcessor {

    // Takes: a filename (UNIX timestamp)
    // Returns: the contents in Turtle/TriG format
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
