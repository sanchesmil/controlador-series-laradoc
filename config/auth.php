<?php



return [

    /*
    |--------------------------------------------------------------------------
    | Padrões de autenticação (Authentication Defaults)
    | ------------------------------------------------- -------------------------
    |
    | Esta sessão controla as opções de proteção de autenticação ("guard") e
    | redefinição de senha ("passwords") para o seu aplicativo. Você pode alterar esses
    | padrões conforme necessário, mas são um começo perfeito para a maioria dos aplicativos.
    |
    */

    // Por padrão o middleware de autenticação (Auth) usa o guard 'web' (Obs.: outros poderão ser definidos)

    'defaults' => [
        'guard' => 'web',
        'passwords' => 'users',
    ],

    /*
    |--------------------------------------------------------------------------
    | Protetores de autenticação  (Authentication Guards)
    | ------------------------------------------------- -------------------------
    |
    | Em seguida, você pode definir todos os protetores (guards) de autenticação para seu aplicativo.
    | Obviamente, aqui você definiu uma ótima configuração padrão, que usa armazenamento
    | de sessão e o provedor de usuários Eloquent (substituído pelo provedor Doctrine logo abaixo).
    |
    | Todos os drivers de autenticação têm um provedor de usuários. Isso define como os
    | usuários são realmente recuperados do banco de dados ou de outros mecanismos de
    | armazenamento usados por este aplicativo para manter os dados do usuário.
    |
    | Suportado: "sessão", "token"
    |
    */

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],

        'api' => [
            'driver' => 'token',
            'provider' => 'users',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Provedores de usuários (User Providers)
    | ------------------------------------------------- -------------------------
    |
    | Todos os drivers de autenticação têm um provedor de usuários.
    | Isso define como os usuários são realmente recuperados do banco de dados
    | ou de outros mecanismos de armazenamento usados por este aplicativo para
    | manter os dados do usuário.
    |
    | Se você tiver várias tabelas ou modelos de usuário, poderá configurar
    | várias fontes que representam cada modelo/tabela. Essas fontes podem
    | ser atribuídas a quaisquer guardas de autenticação extras que você definiu.
    |
    | Suportado: "banco de dados", "eloquente"
    |
    */

    'providers' => [
        'users' => [
            'driver' => 'doctrine',
            'model' => App\Entities\User::class,
        ],

        // 'users' => [
        //     'driver' => 'database',
        //     'table' => 'users',
        // ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Redefinindo senhas (Resetting Passwords)
    | ------------------------------------------------- -------------------------
    |
    | Você pode especificar várias configurações de redefinição de senha se tiver mais
    | de uma tabela ou modelo de usuário no aplicativo e desejar ter configurações
    | de redefinição de senha separadas com base nos tipos de usuário específicos.
    |
    | O tempo de expiração é o número de minutos que o token de redefinição deve ser
    | considerado válido. Esse recurso de segurança mantém os tokens com curta duração,
    | tendo menos tempo para serem adivinhados. Você pode alterar isso conforme necessário.
    */

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_resets',
            'expire' => 60,
        ],
    ],

];
