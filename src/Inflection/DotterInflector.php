<?php namespace StudioIgnis\Evt\Inflection; 

use StudioIgnis\Evt\Inflection\EventNameInflector;

class DotterInflector implements EventNameInflector
{
    /**
     * Generate the event name from the event classname
     *
     * @param string $classname
     * @return string
     */
    public function getName($classname)
    {
        return str_replace('\\', '.', $classname);
    }
}
