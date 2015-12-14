<?php

class Environment
{
    private $memory = [];

    function __construct() {
      $this->set("true",true);
      $this->set("false",false);
    }
    
    public function set($key, $value)
    {
        $this->memory[$key] = $value;
        return true;
    }

    public function get($key)
    {
        if(!isset($this->memory[$key]))
        {
            return null;
        }
        return $this->memory[$key];
    }

    public function exists($key)
    {
      if (isset($this->memory[$key])) {
        return true;
      }
      return false;
    }

    public function cloneEnvironment()
    {
        $clonedEnvironment = new Environment;
        foreach ($this->memory as $key => $value) {
          $clonedEnvironment->set($key,$value);
        }
        return $clonedEnvironment;
    }


}
