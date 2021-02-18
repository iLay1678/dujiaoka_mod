<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Jenssegers\Agent\Agent;
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * 模板渲染.
     * @param string $tpl
     * @param array $data
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    protected function view($tpl = "", $data = [],$template='')
    {
        $agent = new Agent();
        if(!$template){
            if($agent->isMobile()){
                $template=config('app.shmtemplate')?config('app.shmtemplate'):config('app.shtemplate');
            }else{
                $template=config('app.shtemplate');
            }
        }
        $tpl = $template . '/' . $tpl;
        return view($tpl, $data);
    }

    /**
     * 错误模板渲染.
     * @param string $content
     * @param string $url
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    protected function error($content = "content", $url = "")
    {
        $agent = new Agent();
        if($agent->isMobile()){
                $template=config('app.shmtemplate')?config('app.shmtemplate'):config('app.shtemplate');
            }else{
                $template=config('app.shtemplate');
            }
        $tpl = $template . '/errors/error';
        return view($tpl, ['title' => '(╥╯^╰╥)出错啦~', 'content' => $content, 'url' => $url]);
    }
    
    /**
     * 密码模板渲染
    */
    protected function pwd($data=[]){
        $tpl = '/common/password';
        return view($tpl,$data);
    }
}
