<?php


class Dbf
{
    private $handler = false;
    private $searchopt = array (); // Search optimizer

    private function unload ()
    {
        if ($this-> handler !== false)
            unset ($this-> handler);
    }

    public function load ($file)
    {
        $resource = dbase_open ($file, 0);
        $this-> handler = new DBase_Handler ($resource);

        return $this-> handler;
    }


}