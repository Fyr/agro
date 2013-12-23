<?
/**
 * A db table for this model can have any fields to count stats
 *
 */
class Seo extends SeoAppModel {
	var $name = 'Seo';
	var $useTable = 'seo';

	function defaultSeo($aSeo, $defaultTitle = '', $defaultKeywords = '', $defaultDescr = '') {
		if (!(isset($aSeo['title']) && $aSeo['title']) && $defaultTitle) {
			$aSeo['title'] = $defaultTitle;
		}
		if (!(isset($aSeo['keywords']) && $aSeo['keywords']) && $defaultKeywords) {
			$aSeo['keywords'] = $defaultKeywords;
		}
		if (!(isset($aSeo['descr']) && $aSeo['descr']) && $defaultDescr) {
			$aSeo['descr'] = $defaultDescr;
		}
		return $aSeo;
	}
}
