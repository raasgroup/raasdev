<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInitd71dbc456d64a73fe06a9366cc519d60
{
    private static $loader;

    public static function loadClassLoader($class)
    {
        if ('Composer\Autoload\ClassLoader' === $class) {
            require __DIR__ . '/ClassLoader.php';
        }
    }

    /**
     * @return \Composer\Autoload\ClassLoader
     */
    public static function getLoader()
    {
        if (null !== self::$loader) {
            return self::$loader;
        }

        spl_autoload_register(array('ComposerAutoloaderInitd71dbc456d64a73fe06a9366cc519d60', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInitd71dbc456d64a73fe06a9366cc519d60', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInitd71dbc456d64a73fe06a9366cc519d60::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}
