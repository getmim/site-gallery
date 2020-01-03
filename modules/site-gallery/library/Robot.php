<?php
/**
 * Robot
 * @package site-gallery
 * @version 0.0.1
 */

namespace SiteGallery\Library;

use Gallery\Model\Gallery;

class Robot
{
    static private function getPages(): ?array{
        $cond = [
            'updated' => ['__op', '>', date('Y-m-d H:i:s', strtotime('-2 days'))]
        ];
        $pages = Gallery::get($cond);
        if(!$pages)
            return null;

        return $pages;
    }

    static function feed(): array {
        $mim = &\Mim::$app;

        $pages = self::getPages();
        if(!$pages)
            return [];

        $result = [];
        foreach($pages as $page){
            $route = $mim->router->to('siteGallerySingle', (array)$page);
            $meta  = json_decode($page->meta);
            $title = $meta->title ?? $page->title;
            $desc  = $meta->description ?? substr($page->content, 0, 100);

            $result[] = (object)[
                'description'   => $desc,
                'page'          => $route,
                'published'     => $page->created,
                'updated'       => $page->updated,
                'title'         => $title,
                'guid'          => $route
            ];
        }

        return $result;
    }

    static function sitemap(): array {
        $mim = &\Mim::$app;

        $pages = self::getPages();
        if(!$pages)
            return [];

        $result = [];
        foreach($pages as $page){
            $route  = $mim->router->to('siteGallerySingle', (array)$page);
            $result[] = (object)[
                'page'          => $route,
                'updated'       => $page->updated,
                'priority'      => '0.4',
                'changefreq'    => 'monthly'
            ];
        }

        return $result;
    }
}