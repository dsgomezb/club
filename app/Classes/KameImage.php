<?php

namespace App\Classes;

class KameImage
{
    public static function uploadPreviews($model)
    {
        //dd(request()->hasFile('uploadPreviews.files.series.portada:es'));
        $deleteProp = request()->input('deleteProp');
        if (!!$deleteProp) $model->$deleteProp = null;

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
                            
                            $model->images()->create(['src' => $imageName]);
                            $model->$prop = $imageName;
                        }
                    }
                }
            }
        }

        return $model;
    }
}