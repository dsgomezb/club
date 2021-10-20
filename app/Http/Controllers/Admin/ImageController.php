<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;

class ImageController extends Controller
{
    public function update(\App\Image $image)
    {
        $infoCollection = collect();
        collect(request()->all())->each(function ($value, $key) use ($infoCollection, $image) {
            $image = \App\ImageInfo::firstOrNew(['name' => $key, 'image_id' => $image->id]);
            $image->value = $value;
            $infoCollection->push($image);
        });
        $image->info()->saveMany($infoCollection);
        return ['success' => true, 'image' => $image->toArray()];
    }

    public function upload()
    {
        $this->middleWare('progress');
        $response = ['success' => true, 'images' => []];
        foreach (request()->file('images') as $file) {
            $image = $this->intervention($file);
            $response['images'][] = ['src' => $image->src, 'id' => $image->id];
        }
        return response()->json($response);
    }
    public function uploadVideo()
    {
        if ($resource = $this->getVideoThumb(request()->input('video'))) {
            $imagen = $this->intervention($resource);
            $imagen->update(['is_video' => true, 'url' => request()->input('video')]);
            $response = ['error' => false, 'src' => $imagen->src, 'id' => $imagen->id];
        } else {
            $response['error'] = 'Sólo se permiten links de vimeo o youtube.';
        }
        return response()->json($response);
    }

    private function intervention($file)
    {
        $ext = is_string($file) ? '.jpg' :$file->extension();
        $imageName = request()->input('resource'). '.'. \App\Image::nextId(). '.' .$ext;
        $options = config('image.'.request()->input('resource'));
        $path = public_path( '/content/'.request()->input('resource'));
        foreach ($options as $size => $option) {
            $image = Image::make($file);
            foreach ($option as $method => $args) {
                if (!is_array($args)) $args = [$args];
                call_user_func_array([$image, $method], $args);
            }
            $this->createFolder( $path, $size);

            $image->save($path.'/'.$size.'/'.$imageName);
        }
        return \App\Image::create(['src' => $imageName]);
    }

    private function createFolder($path,$size)
    {
        $gitIgnoreContent = "*".PHP_EOL."!.gitignore".PHP_EOL."!imagen-no-disponible.jpg";

        if (!is_dir($path)) {
            mkdir($path);
        }
        if (!is_dir($path.'/'.$size)) {
            mkdir($path.'/'.$size);
            file_put_contents($path.'/'.$size.'/.gitignore', $gitIgnoreContent);
            $img = file_get_contents(public_path( '/content/imagen-no-disponible.jpg'));
            file_put_contents($path.'/'.$size.'/imagen-no-disponible.jpg', $img);
        }
    }

    public function getVideoThumb($url)
    {
        $qualities = ['maxresdefault', 'hqdefault', 'mqdefault', 'sddefault'];
        $response = false;
        if (!filter_var($url, FILTER_VALIDATE_URL)) $response = false;
        $domain = parse_url($url, PHP_URL_HOST);
        if ($domain == 'www.youtube.com' || $domain == 'youtube.com') { // http://www.youtube.com/watch?v=t7rtVX0bcj8&feature=topvideos_film
            if ($querystring = parse_url($url, PHP_URL_QUERY)) {
                parse_str($querystring, $result);
                if (empty($result['v'])) {
                    $response = false;
                } else {
                    foreach ($qualities as $quality) {
                        if (@getimagesize("https://img.youtube.com/vi/{$result['v']}/$quality.jpg")) {
                            $response = "https://img.youtube.com/vi/{$result['v']}/$quality.jpg";
                            break;
                        }
                    }
                }
            } else {
                $response = false;
            }
        } elseif ($domain == 'youtu.be') { // something like http://youtu.be/t7rtVX0bcj8
            $result['v'] = str_replace('/', '', parse_url($url, PHP_URL_PATH));
            $response = (empty($result['v'])) ? false : "http://img.youtube.com/vi/{$result['v']}/maxresdefault.jpg";
        } elseif ($domain == 'vimeo.com') { //vimeo
            //echo($url);
            $url = preg_replace('#(https?)\://vimeo.com/(.*/)?([0-9]{5,})/?$#', '$1://vimeo.com/api/v2/video/$3', $url) . '.php';
            $html_returned = unserialize(file_get_contents($url));
            $response = str_replace('_640.jpg', '_1280.jpg', $html_returned[0]['thumbnail_large']) ;
        } else {
            $response = false;
        }
        return $response;
    }

    //---REST---
    public function destroy(\App\Image $image)
    {
        $image->delete();
        return ['success' => true];
    }
}
