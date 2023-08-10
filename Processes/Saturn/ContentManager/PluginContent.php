<?php

namespace Saturn\Processes\ContentManager;

class PluginContent {
    public function Delete($Plugin) {
        rmdir(__DIR__ . '/../../../Plugins/' . $Plugin);
    }
}