<?php

declare(strict_types = 1);

/**
 *
 * This file is part of DarkMatter for PHP.
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 *
 */
namespace DarkMatter\View;

/**
 *
 * A registry for custom helpers.
 *
 * @package DarkMatter.View
 *
 */
class HelperRegistry
{
    /**
     *
     * The map of registered helpers.
     *
     * @var array
     *
     */
    protected $map = [];

    /**
     *
     * Constructor.
     *
     * @param array $map A map of helpers.
     *
     */
    public function __construct(array $map = [])
    {
        $this->map = $map;
    }

    /**
     *
     * Magic call to invoke helpers as methods on this registry.
     *
     * @param string $name The registered helper name.
     *
     * @param array $args Arguments to pass to the helper invocation.
     *
     * @return mixed
     *
     */
    public function __call($name, $args)
    {
        return call_user_func_array($this->get($name), $args);
    }

    /**
     *
     * Registers a helper.
     *
     * @param string $name Register the helper under this name.
     *
     * @param callable $callable The callable helper.
     *
     * @return null
     *
     */
    public function set($name, $callable)
    {
        $this->map[$name] = $callable;
    }

    /**
     *
     * Is a named helper registered?
     *
     * @param string $name The helper name.
     *
     * @return bool
     *
     */
    public function has($name) : bool
    {
        return isset($this->map[$name]);
    }

    /**
     *
     * Gets a helper from the registry.
     *
     * @param string $name The helper name.
     *
     * @return callable
     *
     */
    public function get($name) : callable
    {
        if (! $this->has($name)) {
            throw new Exception\HelperNotFound($name);
        }

        return $this->map[$name];
    }
}
