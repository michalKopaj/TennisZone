    <?php
    
    spl_autoload_register(function (string $class): void {
        $prefixes = [
            'App\\Core\\'   => __DIR__ . '/app/core/',
            'App\\Models\\' => __DIR__ . '/app/models/',
        ];
    
        foreach ($prefixes as $prefix => $baseDir) {
            $len = strlen($prefix);
            if (strncmp($class, $prefix, $len) !== 0) {
                continue;
            }
            $relative = substr($class, $len);
            $file = $baseDir . str_replace('\\', '/', $relative) . '.php';
            if (is_file($file)) {
                require $file;
                return;
            }
        }
    });
