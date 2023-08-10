<?php

namespace Saturn\ContentManager;

class PluginContent {
    public function Delete($Plugin) {
        return $this->rrmdir(__DIR__ . '/../../../Plugins/' . $Plugin);
    }

    private function rrmdir($dir): bool
    {
        if (is_dir($dir))
        {
            $objects = scandir($dir);

            foreach ($objects as $object)
            {
                if ($object != '.' && $object != '..')
                {
                    if (filetype($dir.'/'.$object) == 'dir') {$this->rrmdir($dir.'/'.$object);}
                    else {unlink($dir.'/'.$object);}
                }
            }

            return rmdir($dir);
        }
        return false;
    }
}