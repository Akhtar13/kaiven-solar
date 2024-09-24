<?php

namespace App\Helpers;

use Illuminate\Support\Facades\File;

class ImageUploadHelper
{
    public static function imageUpload($files, $folder): string
    {
        $image_path = $folder.'/'.date('Y').'/'.date('m');
        if ((string) $folder === 'slider') {
            $image_path = '/uploads/slider/image/';
        }
        if ((string) $folder === 'veterinary_slider') {
            $image_path = '/uploads/veterinary_slider/image/';
        }
        if (! File::exists(public_path().'/'.$image_path)) {
            File::makeDirectory(public_path().'/'.$image_path, 0777, true);
        }
        $extension = $files->getClientOriginalExtension();
        $destination_path = public_path().'/'.$image_path;
        $file_name = uniqid('', true).'.'.$extension;
        $files->move($destination_path, $file_name);

        return $file_name;
    }

    public static function customImageUpload($files, $folder): string
    {
        $image_path = public_path().'/'.'uploads/'.$folder;
        if (! File::exists($image_path)) {
            File::makeDirectory($image_path, 0777, true);
        }
        $extension = $files->getClientOriginalExtension();
        $destination_path = $image_path;
        $file_name = uniqid('', true).'.'.$extension;
        $files->move($destination_path, $file_name);

        return $file_name;
    }

    public static function deleteImage($path): void
    {
        if (File::exists($path)) {
            File::delete($path);
        }
    }

    public static function uploadSimpleImage($file, $folder_name): array
    {

        $image_path = 'uploads/'.$folder_name;

        if (! File::exists(public_path().'/'.$image_path)) {
            File::makeDirectory(public_path().'/'.$image_path, 0777, true);
        }

        $destination_path = public_path().'/'.$image_path;
        $file_name = $file->hashName();
        $file->move($destination_path, $file_name);

        return [
            'success' => true,
            'file_name' => asset($image_path.'/'.$file_name),
        ];
    }
}
