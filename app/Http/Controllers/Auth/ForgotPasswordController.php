<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Controlador de redefinição de senha
    | ------------------------------------------------- -------------------------
    |
    | Este controlador é responsável por gerenciar e-mails de redefinição de senha e
    | inclui uma Trait que auxilia no envio dessas notificações de
    | seu aplicativo para seus usuários. Sinta-se livre para explorar essa característica.
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }
}
