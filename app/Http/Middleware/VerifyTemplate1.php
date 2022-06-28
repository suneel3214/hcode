<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;
use Session;
use App\Models\Page;
class VerifyTemplate1
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $this->url = request()->getHttpHost();
        

        $user = User::select('domain_url','status','template_id','template_name','site_name','site_logo')->firstWhere(['domain_url' => $this->url,'status' => 'A']);

        if(empty($user)){
            $user = User::firstWhere(['domain_url1' => $this->url,'status' => 'A']);
        }
        if(!empty($user)){
           

            $template_name = $user->template_name;
            $site_name = $user->site_name;
            $site_logo = $user->site_logo;
            Session::put('template_name',$template_name);
            Session::put('site_name',$site_name);
            Session::put('site_logo',$site_logo);
            Session::put('user',$user);
        }else{
            abort(404);
        }
        return $next($request);
    }
}
