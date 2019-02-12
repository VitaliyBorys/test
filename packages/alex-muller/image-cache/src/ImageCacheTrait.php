<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 8/31/17
 * Time: 3:44 PM
 */

namespace AlexMuller\ImageCache;

use Image;
use Storage;


trait ImageCacheTrait {
    /**
     * @param integer $w
     * @param integer $h
     * @param null $path
     *
     * @return \Illuminate\Contracts\Routing\UrlGenerator|string
     */
    public function imageResize($w=100, $h=100, $path = null, $heighten = false)
    {
        $path = $path ? : $this->image ? : 'no-image.png';

        return ImageCache::imageResizeStatic($w, $h, $path, $heighten);

    }





}