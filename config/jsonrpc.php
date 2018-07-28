<?php

use Symfony\Component\HttpKernel\Exception\HttpException;
use Nbz4live\JsonRpc\Server\Exceptions\Transformers\HttpExceptionTransformer;

/**
 * Настройки JsonRpc
 */

return [

    /**
     * Пространство имен для контроллеров по умолчанию
     */
    'controllerNamespace' => 'App\\Http\\Controllers\\',

    /**
     * Суффикс для имен контроллеров по умолчанию
     */
    'controllerPostfix' => 'Controller',

    /**
     * Контроллер по умолчанию для методов без имени сервиса (ping)
     */
    'defaultController' => 'Api',

    /**
     * Аутентификация сервиса по ключу
     */
    'authValidate' => false,

    /**
     * Заголовок идентификации сервиса
     */
    'accessHeaderName' => 'X-Access-Key',

    /**
     * Обработчики запросов
     */
    'middleware' => [
        \Nbz4live\JsonRpc\Server\Middleware\ValidateJsonRpcMiddleware::class,     // валидация на стандарты JsonRPC
        //\Nbz4live\JsonRpc\Server\Middleware\ServiceValidationMiddleware::class,   // проверка возможности авторизации под указанным сервисом
        //\Nbz4live\JsonRpc\Server\Middleware\AccessControlListMiddleware::class,   // проверка доступа системы к методу
        \Nbz4live\JsonRpc\Server\Middleware\MethodClosureMiddleware::class,       // возвращает контроллер и метод !!REQUIRED!!
        \Nbz4live\JsonRpc\Server\Middleware\AssociateParamsMiddleware::class,     // ассоциативные параметры
    ],

    /**
     * Ключи доступа к API
     */
    'keys' => [
        'all' => 'TOKEN'
    ],

    /**
     * Разрешенные сервера, которые могут авторизовываться под указанными сервисами
     * Работает только при использовании ServiceValidationMiddleware
     */
    'servers' => [
        //'service1' => ['192.168.0.1', '192.168.1.5'],
        //'service2' => '*',
    ],

    /**
     * Список контроля доступа
     * Ключи массива - методы, значения - массив с наименованием сервисов, которые имеют доступ к указанному методу
     * Работает только при использовании AccessControlListMiddleware
     */
    'acl' => [
        //'App\\Http\\TestController1@method' => ['system1', 'system2'],
        //'App\\Http\\TestController2' => '*',
    ],

    /**
     * Правила роутинга
     * Позволяет иметь на одном хосте несколько JsonRpc-серверов со своими настройками
     *
     * 1. Можно указать URI, по которому будет доступен сервер. В этом случае берутся глобальные настройки сервера
     * [
     *   '/api/v1/jsonrpc', 'api/v2/jsonrpc
     * ]
     *
     * 2. Можно задать свои настройки для каждой точки входа
     * [
     *   '/api/v1/jsonrpc'                  // для этой точки входа будут использованы глобальные настройки
     *
     *   'v2' => [                          // для этой точки входа задаются свои настройки. Если какой-то из параметров не указан - используется глобальный
     *     'uri' => '/api/v1/jsonrpc,                       // URI (обязательный)
     *     'namespace' => 'App\\Http\\Controllers\\V2\\',   // Namespace для контроллеров
     *     'controller' => 'Api',                           // контроллер по умолчанию
     *     'postfix' => 'Controller',                       // суффикс для имен контроллеров
     *     'middleware' => [],                              // список обработчиков запросов
     *     'auth' => true,                                  // аутентификация сервиса
     *     'acl' => [],                                     // Список контроля доступа
     *     'description' => 'JsonRpc server V2'             // описание для SMD схемы
     *   ]
     * ]
     */
    'routes' => [],

    /**
     * List of exception transformers.
     * Exceptions from the array keys will be transformed by the classes in the values
     * to replace them with an JsonRpcException.
     * This way the real exception will be reported to the Laravel/Lumen Handler, but not to the API consumer.
     */
    'exceptionTransformers' => [
        HttpException::class => HttpExceptionTransformer::class,
    ],

    /**
     * Описание сервиса (для SMD-схемы)
     */
    'description' => 'JsonRpc Server',

    /**
     * Настройки логирования
     */
    'log' => [
        /**
         * Канал лога, в который будут записываться все логи
         */
        'channel' => 'default',

        /**
         * Параметры, которые необходимо скрыть из логов
         */
        //'hideParams' => [
        //    'App\\Http\\TestController1@method' => ['password', 'data.phone_number'],
        //    'App\\Http\\TestController2' => ['password', 'data.phone_number']
        //]
    ]

];
