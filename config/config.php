<?php

return [

    /**
     * The namespace where your event listeners are located.
     */
    'listeners_namespace' => 'Acme\Events\Listeners',

    /**
     * Automatically call your event listeners for events that match this
     * pattern. The listeners should be in the 'listeners_namespace'.
     */
    'listen_for' => 'Acme.Events.*',


    // BELOW THIS LINE, MODIFY AT YOUR OUWN RISK


    /**
     * Which concrete dispatcher implementation to map to
     * StudioIgnis\Evt\EventDispatcher contract.
     */
    'dispatcher' => 'StudioIgnis\Evt\Laravel\EventDispatcher',

    /**
     * Which concrete listener implementation to map to
     * StudioIgnis\Evt\EventListener contract.
     */
    'listener' => 'StudioIgnis\Evt\Laravel\EventListener',

    /**
     * Which concrete inflector implementation to map to
     * StudioIgnis\Evt\Inflection\EventNameInflector contract.
     */
    'inflector' => 'StudioIgnis\Evt\Inflection\DotterInflector',
];
