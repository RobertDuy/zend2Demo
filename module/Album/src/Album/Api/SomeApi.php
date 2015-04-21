<?php
use Album\Api\ConfigAwareInterface;

class SomeApi implements ConfigAwareInterface{
    protected $config;

    public function setConfig($config)
    {
        $this->config = $config;
        return $this;
    }

    public function getConfig()
    {
        return $this->config;
    }
}