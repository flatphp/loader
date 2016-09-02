<?php namespace Flatphp\Loader;

class Autoloader
{
    protected static $_dirs = [];
    protected static $_reg = false;

    /**
     * Load the given class file.
     *
     * @param  string  $class
     * @return bool
     */
    public static function load($class)
    {
        $class = ltrim($class, '\\');
        $class = str_replace(array('\\', '_'), DIRECTORY_SEPARATOR, $class) . '.php';

        foreach (static::$_dirs as $dir) {
            $dir = rtrim($dir, '/');
            if (file_exists($path = $dir . DIRECTORY_SEPARATOR . $class)) {
                require_once $path;
            }
        }
    }

    /**
     * Register the given class loader on the auto-loader stack.
     *
     * @return void
     */
    public static function register()
    {
        if (!static::$_reg) {
            static::$_reg = spl_autoload_register(array('self', 'load'));
        }
    }

    /**
     * Add directories to the class loader.
     *
     * @param  string|array  $dirs
     * @return void
     */
    public static function addDirs($dirs)
    {
        static::$_dirs = array_merge(static::$_dirs, (array)$dirs);
        static::$_dirs = array_unique(static::$_dirs);
    }
    
    /**
     * Remove directories from the class loader.
     *
     * @param  string|array  $dirs
     * @return void
     */
    public static function removeDirs($dirs = null)
    {
        if (is_null($dirs)) {
            static::$_dirs = [];
        } else {
            $dirs = (array)$dirs;
            static::$_dirs = array_filter(static::$_dirs, function($dir) use ($dirs) {
                return (!in_array($dir, $dirs));
            });
        }
    }

    /**
     * Gets all the directories registered with the loader.
     *
     * @return array
     */
    public static function getDirs()
    {
        return static::$_dirs;
    }

}

Autoloader::register();