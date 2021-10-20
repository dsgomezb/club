<?php

namespace App\Http\ViewComposers;
 
use Illuminate\Contracts\View\View;
 
class FormComposer {

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        //dd(request()->route()->getName());

        $viewConfig = ['prefix' => time() . '' . rand(1, 99999)];
        $path = request()->path();
        preg_match('#(admin/[0-9a-z-]+)(/([0-9a-z/-]+)/edit)?#', $path, $matches);
        if (count($matches) > 2) {
            $viewConfig['url'] = url('').'/'.$matches[1].'/'.$matches[3];
            $viewConfig['accion'] = 'Editar';
            $viewConfig['method'] = 'PATCH';
            $viewConfig['icon'] = 'pencil';
        } else {
            preg_match('#(admin/[0-9a-z-]+)(/([0-9a-z/-]+)/create)?#', $path, $matches);
            if (count($matches) > 2) {
                $viewConfig['url'] = url('').'/'.$matches[1].'/'.$matches[3];
                $viewConfig['accion'] = 'Crear';
                $viewConfig['method'] = 'Post';
                $viewConfig['icon'] = 'pencil';
            } else {
                $viewConfig['url'] = url('').'/'.$matches[1];
                $viewConfig['accion'] = 'Crear';
                $viewConfig['method'] = 'POST';
            }
        }
        $formOptions = ['method' => $viewConfig['method'], 'url' => $viewConfig['url'], 'id' => 'form', 'enctype' => 'multipart/form-data', 'class' => 'row'];
        $view->with(compact('viewConfig', 'formOptions'));
    }
 
}