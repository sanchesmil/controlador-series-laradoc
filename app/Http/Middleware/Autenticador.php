<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Autenticador
{
    /**
     * Classe que manipula os pedidos de autenticação
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Se a solicitação não for para as páginas de 'entrar' ou 'registrar'
        // e o usuário não estiver logado: redireciona p/ página de 'entrar'

        if(!$request->is('login', 'registrar') && !Auth::check()){
            return redirect('/login');
        }

        // Caso o usuário já esteja autenticado, continua a execução, encaminhando p/ o próximo middler (se houver) ou o controller;
        return $next($request);
    }
}
