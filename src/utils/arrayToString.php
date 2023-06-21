<?php

if (!function_exists('arrayToFile')) {
    /**
     * Credits: wrogati
     * @see https://gist.github.com/wrogati/24c05c8adfe35dd4a0a9df5048e5cc2f
     */
    function arrayToFile(string $path, array $data): void
    {

        $content = var_export($data, TRUE);

        $patterns = [
            "/array \(/" => '[',
            "/^([ ]*)\)(,?)$/m" => '$1]$2',
            "/=>[ ]?\n[ ]+\[/" => '=> [',
            "/([ ]*)(\'[^\']+\') => ([\[\'])/" => '$1$2 => $3',
        ];

        $content = preg_replace(array_keys($patterns), array_values($patterns), $content);

        file_put_contents($path, $content);
    }
}
