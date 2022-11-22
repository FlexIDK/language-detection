<?php
declare(strict_types=1);

$directory_resource = realpath(__DIR__ .
    DIRECTORY_SEPARATOR .
    '..' .
    DIRECTORY_SEPARATOR .
    'resources' .
    DIRECTORY_SEPARATOR
);
if (!is_dir($directory_resource)) {
    return;
}

$files = scandir($directory_resource);
if (!is_array($files)) {
    return;
}

foreach ($files as $file) {
    if (str_starts_with($file, '.')) {
        continue;
    }

    if (!str_ends_with($file, '.json')) {
        continue;
    }

    echo "Read JSON file '{$file}'\n";
    $data = json_decode(file_get_contents($directory_resource . DIRECTORY_SEPARATOR . $file), true);
    if (json_last_error() !== 0) {
        echo "JSON decode error\n";
        continue;
    }

    $name = preg_replace("/\.json$/", "", $file);

    echo "Write file: '{$name}.php'\n";
    file_put_contents(
        $directory_resource . DIRECTORY_SEPARATOR . "{$name}.php",
        "<?php\nreturn " . var_export($data, true) . ";"
    );
}

echo "Done\n";
return 0;
