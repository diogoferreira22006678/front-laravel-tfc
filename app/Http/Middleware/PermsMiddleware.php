<?php
namespace App\Http\Middleware;

use Closure;
use App\Models\Admin;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;

class PermsMiddleware{
  use \App\Traits\ApiUtils;

  public function handle($request, Closure $next, $perm_name=null){
    $user = Admin::getCurrent();
    if($user == null){
      return redirect('/admin/login')->with(['redirect' => $request->url()]);
    }
    if($perm_name == null ||
       substr($perm_name, 0, 1) == '_' ||
       $user->canSee($perm_name)){
      goto next;
    }

    return $this->permError($request);

    next:
    \View::share('loginUser', $user);
    return $next($request);
  }

  private function permError($request){
    $err = "Não tens permissões para fazer esta operação.";
    $route = $request->route();
    $action = $route->action;
    $middleware = $action['middleware'];
    if(in_array('api_exception', $middleware)){
      throw new \Exception($err);
    }else{
      return back()->withErrors(['popup-error' => $err]);
    }
  }

}
