<?php

/*
 * This file is part of the Predis package.
 *
 * (c) Daniele Alessandri <suppakilla@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CloudServer;

class autoloader
{
    private $directory;
    private $prefix;
    private $prefixLength;


    public function __construct($baseDirectory = __DIR__)
    {
        $this->directory = $baseDirectory;
        $this->prefix = __NAMESPACE__ . '\\';
        $this->prefixLength = strlen($this->prefix);
    }

    public static function register($prepend = false)
    {
        spl_autoload_register(array(new self(), 'autoload'), true, $prepend);
    }

    public function autoload($className)
    {
        if (0 === strpos($className, $this->prefix)) {
            $parts = explode('\\', substr($className, $this->prefixLength));
            $filepath = $this->directory . DIRECTORY_SEPARATOR . implode(DIRECTORY_SEPARATOR, $parts) . '.php';

            if (is_file($filepath)) {
                require $filepath;
            }
        }
    }
}
