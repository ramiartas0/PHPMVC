<?php

class Route
{
    public static function parse_url()
    {
        $dirname = dirname($_SERVER['SCRIPT_NAME']);
        $dirname = $dirname != '/' ? $dirname : null;
        $basename = basename($_SERVER['SCRIPT_NAME']);
        $request_uri = str_replace([$dirname, $basename], null, $_SERVER['REQUEST_URI']);
        return $request_uri;
    }

    public static function run($url, $callback, $method = 'get')
    {
        $method = explode('|', strtoupper($method));

        if (in_array($_SERVER['REQUEST_METHOD'], $method)) {

            $patterns = [
                '{url}' => '([0-9a-zA-Z]+)',
                '{id}' => '([0-9]+)'
            ];

            $url = str_replace(array_keys($patterns), array_values($patterns), $url);

            $request_uri = self::parse_url();
            if (preg_match('@^' . $url . '$@', $request_uri, $parameters)) {
                unset($parameters[0]);

                if (is_callable($callback)) {
                    call_user_func_array($callback, $parameters);
                } else {
                    $controller = explode('@', $callback);
                    $controllerName = ucfirst($controller[0]) . 'Controller';
                    $methodName = $controller[1];
                    $controllerFile = __DIR__ . '/../../../controller/' . strtolower($controllerName) . '.php';

                    if (file_exists($controllerFile)) {
                        require_once $controllerFile;
                        // Değişiklik burada: Controller sınıfı çağrılırken değiştirildi
                        call_user_func_array([new $controllerName, $methodName], $parameters);
                    } else {
                        echo "Controller dosyası bulunamadı: $controllerFile";
                    }
                }
            }
        }
    }
}
