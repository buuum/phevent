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
     * @param array $args
     * @return mixed
     */
    public function fire($event_name, $args = [])
    {
        $listener = $this->ensureEventName($event_name);

        $args = !empty($args) ? $args : func_get_args();
        $arguments = $args + [$event_name];
        $method = ($this->resolver) ? $this->resolver->resolve($listener) : $listener;

        return call_user_func_array($method, $arguments);
    }

    /**
     * @param $event_name
     * @return mixed
     */
    public static function eventFire($event_name)
    {
        $event = self::getInstance();
        return $event->fire($event_name, func_get_args());
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
     * @param $event_name
     * @return mixed
     */
    protected function ensureEventName($event_name)
    {
        if (!isset($this->listeners[$event_name])) {
            throw new \InvalidArgumentException("The event $event_name doesn't exist.");
        }

        return $this->listeners[$event_name];
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