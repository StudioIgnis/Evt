<?php namespace StudioIgnis\Evt\Inflection;

interface EventNameInflector
{
    /**
     * Generate the event name from the event classname
     *
     * @param string $classname
     * @return string
     */
    public function getName($classname);
}
