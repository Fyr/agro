<?
class ProductsController extends SiteController {
	const PER_PAGE = 51;
	const PARAM_TITLE_ID = 11; // id=10

	var $components = array('articles.PCArticle', 'grid.PCGrid');
	var $helpers = array('core.PHA', 'core.PHCore', 'Time', 'core.PHTime', 'articles.HtmlArticle', 'ArticleVars');
	var $uses = array('articles.Article', 'media.Media', 'seo.Seo', 'SiteArticle', 'SiteProduct', 'params.Param', 'params.ParamObject', 'params.ParamValue', 'tags.TagObject', 'SiteCategory');

	private function getCategoryID($slug) {
		// return str_replace('-', '', strrchr($category, '-'));
		$cat = $this->SiteCategory->findByPageId($slug);
		return $cat['Article']['id'];
	}

	function beforeFilterLayout() {
		parent::beforeFilterLayout();

		$this->categoryID = (isset($this->params['category']) && $this->params['category']) ? $this->getCategoryID($this->params['category']) : '';
		$this->subcategoryID = (isset($this->params['subcategory']) && $this->params['subcategory']) ? $this->getCategoryID($this->params['subcategory']) : '';

		$catID = 0;
		if ($this->subcategoryID) {
			$this->params['url']['data']['filter']['Article.subcat_id'] = $this->subcategoryID;
			$catID = $this->subcategoryID;
		} elseif ($this->categoryID) {
			$this->params['url']['data']['filter']['Article.cat_id'] = $this->categoryID;
			$catID = $this->categoryID;
		} elseif (isset($this->params['url']['data']['filter'])) {
			$this->set('directSearch', true);
		}

		if ($this->categoryID) {
			$this->set('cat_autoOpen', $this->categoryID);
		}
	}

	function index() {
		$this->Article = $this->SiteProduct;
		$this->grid['Article'] = array(
			'conditions' => array('Article.object_type' => 'products', 'Article.published' => 1),
			'fields' => array(
				'Category.id', 'Category.title', 'Category.object_type', 'Category.object_id', 'Category.page_id', 
				'Subcategory.id', 'Subcategory.title', 'Subcategory.object_type', 'Subcategory.object_id', 'Subcategory.page_id', 
				'Article.object_type', 'Article.title', 'Article.title_rus', 'Article.page_id', 'Article.teaser', 'Article.featured', 'Article.price', 'Article.active', 'Article.code'
			),
			'order' => array('Article.featured' => 'desc', 'Article.sorting' => 'asc'),
			'limit' => self::PER_PAGE
		);

		$aFilters = $this->_getFilters();
		$this->grid['Article']['conditions'] = array_merge($this->grid['Article']['conditions'], $aFilters['conditions']);

		$aArticles = $this->PCGrid->paginate('Article');
		$this->set('aArticles', $aArticles);
		$this->set('aFilters', $aFilters);

		$this->aBreadCrumbs = array('/' => 'Home', 'Products');
		$page_title = __('Products', true);

		if (isset($this->params['url']['data']['filter']['Article.cat_id']) && $this->params['url']['data']['filter']['Article.cat_id']) {
			$categoryID = $this->params['url']['data']['filter']['Article.cat_id'];
			$category = $this->SiteCategory->findById($categoryID);
			$page_title = $category['Article']['title'];
			$this->aBreadCrumbs = array('/' => 'Home', '/products/' => 'Products', $page_title); // '/products/?data[filter][type_id]='.$categoryID =>

			$relatedContentSeo = null;
			if (!(isset($this->params['page']) && intval($this->params['page']) > 1)) {
				/*$relatedContent = $this->Article->find('first', array('conditions' => array(
					'Article.object_type' => 'category', 'Article.object_id' => $categoryID, 'Article.published' => 1
				)));
				*/
				$this->set('relatedContent', $category);
				$relatedContentSeo = $category['Seo'];
			}
			$this->data['SEO'] = $this->Seo->defaultSeo($relatedContentSeo,
				'Каталог продукции '.$page_title,
				"каталог продукции {$page_title}, запчасти для тракторов {$page_title}, запчасти для спецтехники {$page_title}, запчасти для {$page_title}",
				"На нашем сайте вы можете приобрести лучшие запчасти {$page_title} в Белорусии. Низкие цены на спецтехнику, быстрая доставка по стране, диагностика, ремонт."
			);
			$this->pageTitle = $this->data['SEO']['title'];
		} elseif (isset($this->params['url']['data']['filter']['Article.subcat_id']) && $this->params['url']['data']['filter']['Article.subcat_id']) {
			$subcategoryID = $this->params['url']['data']['filter']['Article.subcat_id'];
			$subcategory = $this->SiteCategory->findById($subcategoryID);
			$categoryID = $subcategory['Article']['object_id'];
			$category = $this->SiteCategory->findById($categoryID);

			$page_title = $subcategory['Category']['title'];
			$this->aBreadCrumbs = array('/' => 'Home', '/products/' => 'Products', '/products/?data[filter][type_id]='.$categoryID => $category['Category']['title'], $page_title); //

			$relatedContentSeo = null;
			if (!(isset($this->params['page']) && intval($this->params['page']) > 1)) {
				/*
				$relatedContent = $this->Article->find('first', array('conditions' => array(
					'Article.object_type' => 'category', 'Article.object_id' => $subcategoryID, 'Article.published' => 1
				)));
				*/
				$this->set('relatedContent', $subcategory);
				$relatedContentSeo = $subcategory['Seo'];
			}
			$this->data['SEO'] = $this->Seo->defaultSeo($relatedContentSeo,
				'Каталог продукции '.$page_title,
				"каталог продукции {$page_title}, запчасти для тракторов {$page_title}, запчасти для спецтехники {$page_title}, запчасти для {$page_title}",
				"На нашем сайте вы можете приобрести лучшие запчасти {$page_title} в Белорусии. Низкие цены на спецтехнику, быстрая доставка по стране, диагностика, ремонт."
			);
			$this->pageTitle = $this->data['SEO']['title'];
		}

		if (!$aFilters['conditions']) {
			$this->pageTitle = 'Каталог продукции';
			$this->data['SEO'] = array(
				'keywords' => 'каталог продукции, запчасти для трактора, запчасти для спецтехники, запчасти для автомобилей',
				'descr' => 'На нашем сайте вы можете приобрести лучшие запчасти для трактора в Белорусии. Низкие цены на спецтехнику, быстрая доставка по стране, диагностика, ремонт.'
			);
		}
		if (isset($_GET['data']['filter'])) {
			$page_title = 'Результаты поиска';
		}
		$this->set('page_title', $page_title);
	}

	function view($id = 0) {
		if ($id) {
			$aArticle = $this->SiteProduct->findById($id);
		} else {
			$aArticle = $this->SiteProduct->findByPageId($this->params['id']);
			if (!$aArticle) {
				$aArticle = $this->SiteProduct->findById(str_replace('.html', '', $this->params['id']));
			}
		}
		if (!$aArticle) {
			return $this->redirect('/');
		}
		
		// fdebug($this->params);
		App::import('Helper', 'Router');
		$this->Router = new RouterHelper();
		if ($this->params['category'] !== $aArticle['Category']['page_id'] 
				|| $this->params['subcategory'] !== $aArticle['Subcategory']['page_id']) {
			return $this->redirect($this->Router->url($aArticle));
		}
		
		$id = $aArticle['Article']['id'];
		
		unset($aArticle['Media']);
		$aArticle['Media'] = $this->Media->getMedia('Article', $aArticle['Article']['id']);
		$this->set('aArticle', $aArticle);

		$this->pageTitle = (isset($aArticle['Seo']['title']) && $aArticle['Seo']['title']) ? $aArticle['Seo']['title'] : $aArticle['Article']['title_rus'];
		$aArticle['Seo'] = $this->Seo->defaultSeo($aArticle['Seo'],
			$aArticle['Article']['title_rus'],
			$aArticle['Article']['title_rus'].", ".str_replace(',', ' ', $aArticle['Article']['title_rus'])." ".$aArticle['Category']['title'].", запчасти для спецтехники ".$aArticle['Category']['title'].", запчасти для ".$aArticle['Category']['title'],
			'На нашем сайте вы можете приобрести '.str_replace(',', ' ', $aArticle['Article']['title_rus']).' для трактора или спецтехники '.$aArticle['Category']['title'].' в Белорусии. Низкие цены на спецтехнику, быстрая доставка по стране, диагностика, ремонт.'
		);
		$this->data['SEO'] = $aArticle['Seo'];
		$this->set('aParamValues', $this->ParamValue->getValueOptions('ProductParam', $id));
		$aSimilar = $this->SiteProduct->find('all', array(
			'conditions' => array('Article.object_type' => 'products', 'Article.published' => 1, 'Article.object_id' => $aArticle['Article']['object_id'], 'Article.id <> ' => $id)
		));
		$this->set('aSimilar', $aSimilar);

		// $subcategory = $aArticle['Subcategory'];
		$categoryID = $aArticle['Category']['id'];
		$category = $aArticle['Category']['title']; // $this->Category->findById($categoryID);
		$this->aBreadCrumbs = array('/' => 'Home', '/products/' => 'Products', '/products/?data[filter][type_id]='.$categoryID => $category, __('View product', true)); //
	}

	private function _getFilters() {
		$filtersData = (isset($this->params['url']['data']['filter'])) ? $this->params['url']['data']['filter'] : array();
		$aConditions = array();
		$aURL = array();
		foreach($filtersData as $key => $value) {
			if ($value !== '') {
				if (is_array($value)) {
					foreach($value as $value1) {
						$aURL[] = 'data[filter]['.$key.'][]='.$value1;
					}
				} else {
					$aURL[] = 'data[filter]['.$key.']='.$value;
				}

				if ($key == 'type_id') {
					$aSubtypes = $this->Category->find('list', array('conditions' => array('Category.object_id' => $value)));
					$aConditions['Article.object_id'] = array_keys($aSubtypes);
				} elseif ($key == 'Article.title') {
					$value = str_replace(array('.', ' ', '-', ',', '/', '\\'), '', $value);
					$aConditions[] = '(Article.title LIKE "%'.$value.'%" OR Article.title_rus LIKE "%'.$value.'%" OR Article.detail_num LIKE "%'.$value.'%")';
				} elseif ($key == 'Tag.id') {
					$aRows = $this->TagObject->find('list', array('fields' => array('TagObject.object_id', 'TagObject.object_type'), 'conditions' => array('TagObject.tag_id' => $value)));
					$aConditions['Article.id'] = array_keys($aRows);
				/*
				if ($key == 'pricelist') {
					$aConditions['pricelist <> '] = '""';
					$aConditions['tarif > '] = 1;
					// $aConditions[] = 'paid';
				} elseif ($key == 'paytype_id') {
					if (is_array($value)) {
						foreach($value as $paytype_id) {
							$cond = '(SELECT DISTINCT 1 FROM cat_paytypes AS CatPaytype WHERE CatPaytype.catalog_id = Catalog.id AND CatPaytype.paytype_id = '.$paytype_id.')';
							$aConditions[] = $cond;
						}
					}
				} elseif ($key == 'subsection_id') {
					$cond = '(SELECT DISTINCT 1 FROM cat_services AS CatService WHERE CatService.catalog_id = Catalog.id AND CatService.subsection_id = '.$value.')';
					$aConditions[] = $cond;
				} elseif($key == 'section_id') {
					$cond = '(SELECT DISTINCT 1 FROM cat_services AS CatService JOIN cat_subsections AS CatSubsection ON CatSubsection.id = CatService.subsection_id WHERE CatService.catalog_id = Catalog.id AND CatSubsection.section_id = '.$value.')';
					$aConditions[] = $cond;
					*/
				} else {
					$aConditions[$key] = $value;
				}
			}
		}
		return array('conditions' => $aConditions, 'url' => implode('&', $aURL));
	}

}
