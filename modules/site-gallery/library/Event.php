<?php
/**
 * Event
 * @package site-gallery
 * @version 0.0.1
 */

namespace SiteGallery\Library;


class Event
{
    static function clear(array $data): void{
        $page = $data['page'] ?? $data['old'] ?? null;

        // clear output cache
        if($page && module_exists('lib-cache-output'))
            Cleaner::router('siteGallerySingle', (array)$page);

        // Clear gallery RSS Feed output cache
        // Clear global RSS Feed output cache
        // Clear global Sitemap output cache
    }
}