<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 6/6/18
 * Time: 10:09 AM
 */

namespace App\Http\Helpers;

use Illuminate\Database\Eloquent\Model;
use Storage;

class ImageUpload
{
    public function upload(string $input_name, Model $model)
    {
        if (request()->hasFile($input_name)) {
            //Remove old avatar if exists
            if( $model->$input_name && Storage::exists( $model->$input_name ) ){
                Storage::delete( $model->$input_name );
            }

            $path = request()->file($input_name)->store(str_plural($input_name));

            if($model->id){
                $model->$input_name = $path;
                $model->save();
            }

            return $path;
        }
        if (request()->$input_name == 'remove') {
            if( $model->$input_name && Storage::exists( $model->$input_name ) ){
                Storage::delete( $model->$input_name );
                $model->$input_name = null;
                $model->save();
            }
        }

        return '';
    }
}