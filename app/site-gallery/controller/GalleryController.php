<?php
/**
 * GalleryController
 * @package site-gallery
 * @version 0.0.1
 */

namespace SiteGallery\Controller;

use SiteGallery\Meta\Gallery as Meta;
use Gallery\Model\Gallery;
use LibFormatter\Library\Formatter;

class GalleryController extends \Site\Controller
{
    public function singleAction() {
        $slug = $this->req->param->slug;

        $gallery = Gallery::getOne(['slug'=>$slug]);
        if(!$gallery)
            return $this->show404();

        $gallery = Formatter::format('gallery', $gallery, ['user']);

        $params = [
            'gallery' => $gallery,
            'meta'    => Meta::single($gallery)
        ];

        $this->res->render('gallery/single', $params);
        $this->res->setCache(86400);
        $this->res->send();
    }
}