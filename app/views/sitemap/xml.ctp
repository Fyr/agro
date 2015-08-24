<? echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset
      xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
      xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
      xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
            http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
<?
	foreach($aMenu as $item) {
?>
<url>
  <loc>http://<?=DOMAIN_NAME?><?=$item['href']?></loc>
  <changefreq>daily</changefreq>
</url>
<?
	}
	foreach($aCategories as $category) {
		$url = $this->Router->catUrl('products', $category['Category']);
?>
<url>
  <loc>http://<?=DOMAIN_NAME.$url?></loc>
  <changefreq>daily</changefreq>
</url>
<?
	}
?>
</urlset>
