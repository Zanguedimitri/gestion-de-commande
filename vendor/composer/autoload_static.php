<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit272ce7e9e2905f99a03df20836a27fba
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'PHPMailer\\PHPMailer\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit272ce7e9e2905f99a03df20836a27fba::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit272ce7e9e2905f99a03df20836a27fba::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit272ce7e9e2905f99a03df20836a27fba::$classMap;

        }, null, ClassLoader::class);
    }
}
