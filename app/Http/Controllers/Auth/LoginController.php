<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Controlador de login
    |--------------------------------------------------------------------------
    |
    | Este controlador lida com a autenticação de usuários para o aplicativo e
    | redirecionando-os para sua tela inicial. O controlador usa uma Trait
    | para fornecer outras funcionalidade necessárias.
    |
    */

    use AuthenticatesUsers;

    /**
     * Para onde redirecionar os usuários após o login.
     *
     * @var string
     */
    protected $redirectTo = '/series';

    /**
     * @var int
     */
    private $maxAttempts;   // Define o número de tentativas p/ login

    /**
     * @var int
     */
    private $decayMinutes;   // Define o tempo de bloqueio após atingir número de tentativas

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //Simplesmente registra o middleware 'guest' neste controlador, excluindo o método 'logout'
        $this->middleware('guest')->except('logout');

        /* Seta os valores de bloqueio para erros de login:
        *  Após 5 tentativas erradas, bloqueia o mesmo IP por 1 min
        */
        $this->decayMinutes  = 1;  // bloqueia o acesso por 1 min
        $this->maxAttempts = 3;    // bloqueia após 5 tentativas erradas
    }
}
