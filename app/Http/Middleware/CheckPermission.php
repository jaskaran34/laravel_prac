<?php

namespace App\Http\Middleware;
use App\Models\log;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Exception;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

       //dd(url()->previous());exit;
        try{
        if(request()->route()->action['as']){
            $name_of_route=request()->route()->action['as'];
        }
        else{
            
            $name_of_route='NULL';
        }
    }
    catch(Exception  $e){
        $name_of_route='NULL';
    }
        
    log::create([
    'ip'=> request()->ip(),
    'route'=>$name_of_route,
    'route_url'=>url()->current(),
    'route_path'=>$request->path(),
    'prev_url'=>url()->previous()

]);

        return $next($request);
    }
}
