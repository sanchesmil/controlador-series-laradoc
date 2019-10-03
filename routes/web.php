<?php

/*
|--------------------------------------------------------------------------
| Rotas da Web
| ------------------------------------------------- -------------------------
|
| Aqui é onde você pode registrar rotas da web para seu aplicativo. Estas
| rotas são carregadas pelo RouteServiceProvider dentro de um grupo que
| contém o grupo de middleware "web".
|
*/

use Illuminate\Support\Facades\Auth;

/*
 * Define as rotas de autenticação (login,logout,register)
 */

Route::get('/', function () {
    return redirect('/series');  // Redireciona p/ página principal da aplicação
});

//Auth::routes() é uma classe auxiliar que ajuda a gerar todas as rotas necessárias para a autenticação do usuário
Auth::routes();

// Logout com método (get)
Route::get('/logout', function (){
    Auth::guard()->logout();
    return redirect('/series');  // Redireciona p/ página principal da aplicação
});

Route::get('/home', 'HomeController@index')->name('home');


/*
 * Define as rotas da aplicação
 */

Route::get('/series', 'SeriesController@index')->name('listar_series');

Route::get('series/criar', 'SeriesController@create') // Redireiona p/ o form de criação de série
            ->name('form_criar_serie')                // Dá um 'alias/nome' para a rota que cria uma série (via GET)
            ->middleware('autenticador');             // Protege a rota, chamando o middler de autententicacao de usuarios antes de redirecionar p/ o método 'create' do controller;

Route::post('series/criar', 'SeriesController@store') // Armazena a nova série no banco (via POST)
        ->middleware('autenticador');                 // Antes de criar a série, chama o middler de autenticacao de usuarios

Route::delete('/series/{serieId}', 'SeriesController@destroy') // Exclui uma série do banco (via DELETE) passando um argumento
        ->middleware('autenticador');

Route::post('/series/{serieId}/editaNome', 'SeriesController@editaNome')
       ->middleware('autenticador');

Route::get('/series/{serieId}/temporadas', 'TemporadasController@index');  // Permite visualizar as temporadas sem estar autenticado

Route::get('/temporada/{temporadaId}/episodios', 'EpisodiosController@index');  // Permite visualizar os episódios sem estar autenticado

Route::post('/temporadas/{temporadaId}/episodios/assistir', 'EpisodiosController@assistir')   // Permite marcar os episódios como assistidos somente quem está autenticado
        ->middleware('autenticador');
