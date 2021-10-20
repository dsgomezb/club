<?php

namespace App\Http\Controllers;

use Illuminate\Support\Arr;

class AppController extends Controller
{
    protected $class;
    protected $viewFolder;
    protected $path;
    protected $mustValidate = true;
    protected $needAuthorization = true;

    public function json()
    {
        if ($this->needAuthorization) $this->authorize('viewAny', $this->class);
        $data = $this->jsonQuery($this->class::tabulated())->get();
        $recordsTotal =$this->jsonQuery($this->class::query())->count();
        $recordsFiltered = $this->jsonQuery($this->class::filtered())->count();
        return compact('data', 'recordsTotal', 'recordsFiltered');
    }

    public function index()
    {
        if ($this->needAuthorization) $this->authorize('viewAny', $this->class);
        return view($this->viewFolder.".index");
    }

    public function create()
    {
        if ($this->needAuthorization) $this->authorize('create', $this->class);
        $model = new $this->class;
        return view($this->viewFolder.".kame-form", compact('model'));
    }

    public function store()
    {
        if ($this->needAuthorization) $this->authorize('create', $this->class);

        $model = new $this->class(request()->all());

        $this->beforeCreate($model);

        $this->persist($model);

        $this->afterCreate($model);
        
        return $this->getResponse($model);
    }

    public function edit($id)
    {
        if ($this->needAuthorization) $this->authorize('update', new $this->class);
        // TODO: Chequear si dejar esto
        // $model = $this->findModel($id);
        $model = $this->class::find($id);
        return view ($this->viewFolder.".kame-form", compact('model'));
    }

    public function update($id)
    {
        $model = $this->class::find($id);

        if ($this->needAuthorization) $this->authorize('update', $model);

        $model->fill(request()->all());

        $this->beforeUpdate($model);

        $this->persist($model);

        $this->afterUpdate($model);
    
        return $this->getResponse($model);
    }

    public function destroy($id)
    {
        $this->beforeDelete($model);
        $model = $this->class::find($id);
        if ($this->needAuthorization) $this->authorize('delete', $model);
        $model->delete();
        $this->afterDelete();
        return ['success' => true];
    }

    protected function getPath()
    {
        if (!$path = $this->path) {
            $path = str_replace('.', '/', $this->viewFolder);
        }
        return $path;
    }

    protected function persist($model)
    {
        $this->beforeSave($model);
        $this->uploadPreviews($model);
        $this->validation();

        $model->save();
    }

    protected function getResponse($model)
    {
        $this->afterSave($model);
        $this->addImages($model);
        //$this->addVariants($model);

        return request()->ajax() ? $model->toArray() : $this->redirect($model);
    }

    protected function validation()
    {
        if ($this->mustValidate) {
            $model = str_replace('App\\', '', $this->class);
            $validatorPath = 'App\Http\Requests\\' . $model . 'Request';
            $validator = new $validatorPath;

            request()->validate($validator->rules(), $validator->messages(), $validator->attributes());
        }
    }

    protected function addImages($model)
    {
        //slider
        if (request()->input('imageId')) {
            $images = \App\Image::find(request()->input('imageId'));
            $model->images()->delete();
            $model->images()->save($images);
            $images->update(['pending'=>0]);
        }

        if (request()->has('imagesIds')) {
            $images = \App\Image::whereIn('id', request('imagesIds'));
            $model->images()->saveMany($images->get());
            $images->update(['pending'=>0]);
        }

        $model->save();
    }

    protected function uploadPreviews($model)
    {
        $deleteProp = request()->input('deleteProp');
        if (!!$deleteProp) $model->$deleteProp = '';

        if (request()->has('uploadPreviews')) {
            $uploadPreviews = request()->input('uploadPreviews');
            foreach ($uploadPreviews as $uploadPreview) { //itero por cada uploader que puede haber en la vista
                foreach ($uploadPreview as $resouce => $props) {
                    foreach ($props as $prop) {
                        if (request()->hasFile("uploadPreviews.files.$resouce.$prop")) {
                            $options = config("image.$resouce");
                            $file = request()->file("uploadPreviews.files.$resouce.$prop");
                            $imageName = $resouce . '.'. uniqid(). '.' .$file->extension();
                            foreach ($options as $size => $option) {

                                $image = \Image::make($file);
                                foreach ($option as $method => $args) {
                                    if (!is_array($args)) $args = [$args];
                                    call_user_func_array([$image, $method], $args);
                                }
                                $image->save(public_path( "/content/$resouce/$size/$imageName"));
                            }
                            $model->$prop = $imageName;
                        }
                    }
                }
            }
        }

        return $model;
    }

    protected function beforeCreate($model)
    {
        //
    }

    protected function afterCreate($model)
    {
        //
    }

    protected function beforeUpdate($model)
    {
        //
    }

    protected function afterUpdate($model)
    {
        //
    }

    protected function beforeSave($model)
    {
        //
    }

    protected function afterSave($model)
    {
        //
    }

    protected function beforeDelete($model)
    {
        //
    }

    protected function afterDelete()
    {
        //
    }

    protected function jsonQuery($query)
    {
        return $query;
    }

    protected function redirect($model)
    {
        return redirect($this->getPath());
    }

    protected function findModel($id){
        return $this->class::find($id);
    }
}
