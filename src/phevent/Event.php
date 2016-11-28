<?php

namespace Buuum;

class Event
{

    /**
     * @var Event
     */
    private static $instance;

    /**
     * @var array
     */
    protected $listeners = [];

    /**
     * @var EventResolverInterface
     */
    protected $resolver = null;

    /**
     * @param $event_name
     * @param $handle
     * @return $this
     */
    public function addListener($event_name, $handle)
    {
        $listener = $this->ensureListener($handle);
        $this->listeners[$event_name] = $listener;
        return $this;
    }

    /**
     * @param \Closure $listeners
     */
    public function loadListeners(\Closure $listeners)
    {
        $listeners($this);
    }

    /**
     * @param $event_name
     * @return mixed
     */
    public function fire($event_name)
    {
        $arguments = [$event_name] + func_get_args();

        $method = ($this->resolver) ? $this->resolver->resolve($this->listeners[$event_name]) : $this->listeners[$event_name];

        return call_user_func_array($method, $arguments);
    }

    /**
     * @param $event_name
     * @return mixed
     */
    public static function eventFire($event_name)
    {
        $event = self::getInstance();
        return $event->fire($event_name);
    }

    /**
     * @param EventResolverInterface $resolver
     */
    public function setResolver(EventResolverInterface $resolver)
    {
        $this->resolver = $resolver;
    }

    /**
     * @param $listener
     * @return mixed
     */
    protected function ensureListener($listener)
    {
        if (is_callable($listener)) {
            return $listener;
        }
        throw new \InvalidArgumentException('Listeners should be Closure or callable. Received type: ' . gettype($listener));
    }

    /**
     * @return Event
     */
    public static function getInstance()
    {
        if (null === static::$instance) {
            static::$instance = new static();
        }

        return static::$instance;
    }

}