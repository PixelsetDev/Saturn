<?php

namespace Saturn\PluginManager;

class ContentManager
{
    public function Delete($Plugin)
    {
        return $this->rrmdir(__DIR__.'/../../../Plugins/'.$Plugin);
    }

    private function rrmdir($Directory): bool
    {
        if (is_dir($Directory)) {
            $Objects = scandir($Directory);

            foreach ($Objects as $Object) {
                if ($Object != '.' && $Object != '..') {
                    if (filetype($Directory.'/'.$Object) == 'dir') {
                        $this->rrmdir($Directory.'/'.$Object);
                    } else {
                        unlink($Directory.'/'.$Object);
                    }
                }
            }

            return rmdir($Directory);
        }

        return false;
    }
}
