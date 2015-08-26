<?
class ProductsController extends SiteController {
	const PER_PAGE = 51;

	var $components = array('articles.PCArticle', 'grid.PCGrid');
	var $helpers = array('core.PHA', 'core.PHCore', 'Time', 'core.PHTime', 'articles.HtmlArticle', 'ArticleVars');
	var $uses = array('articles.Article', 'media.Media', 'MediaProduct', 'seo.Seo', 'SiteArticle', 'SiteProduct', 'params.Param', 'params.ParamValue', 'SiteCategory', 'Brand');
	
	protected $Router, $category = array(), $subcategory = array();

	function beforeFilterLayout() {
		parent::beforeFilterLayout();
		
		App::import('Helper', 'Router');
		$this->Router = new RouterHelper();
		
		$catID = 0;
		if (isset($this->params['subcategory']) && $this->params['subcategory']) {
			$this->subcategory = $this->SiteCategory->findByPageId($this->params['subcategory']);
			$catID = $this->subcategory['Category']['id'];
		}
		if (isset($this->params['category']) && $this->params['category']) {
			$this->category = $this->SiteCategory->findByPageId($this->params['category']);
			$catID = $this->category['Article']['id'];
		}

		if ($catID) {
			$this->set('cat_autoOpen', $catID);
		}
	}

	function index() {
		$this->Article = $this->SiteProduct;
		$this->grid['Article'] = array(
			'conditions' => array('Article.object_type' => 'products', 'Article.published' => 1),
			'fields' => array(
				'Category.id', 'Category.title', 'Category.object_type', 'Category.object_id', 'Category.page_id', 
				'Subcategory.id', 'Subcategory.title', 'Subcategory.object_type', 'Subcategory.object_id', 'Subcategory.page_id', 
				'Article.id', 'Article.object_type', 'Article.title', 'Article.title_rus', 'Article.page_id', 'Article.teaser', 'Article.featured', 'Article.price', 'Article.active', 'Article.code', 'Article.brand_id'
			),
			'order' => array('Article.featured' => 'desc', 'Article.sorting' => 'asc'),
			'limit' => self::PER_PAGE
		);
		
		$page_title = 'Products';
		$this->aBreadCrumbs = array('/' => 'Home', $page_title);
		$this->pageTitle = __($page_title, true);
		$this->data['SEO'] = array(
			'keywords' => 'каталог продукции, запчасти для трактора, запчасти для спецтехники, запчасти для автомобилей',
			'descr' => 'На нашем сайте вы можете приобрести лучшие запчасти для трактора в Белорусии. Низкие цены на спецтехнику, быстрая доставка по стране, диагностика, ремонт.'
		);
		
		$filter = (isset($this->params['url']['data']['filter'])) ? $this->params['url']['data']['filter'] : array();
		if ($filter) {
			$page_title = __('Search results', true);
			$this->pageTitle = $page_title;
			$this->aBreadCrumbs = array(
				'/' => 'Home', 
				$this->Router->getDir('products') => 'Products', 
				$page_title
			);
			$this->set('directSearch', true);
		} elseif ($this->subcategory) {
			$filter['Article.subcat_id'] = $this->subcategory['Article']['id'];
			
			$page_title = $this->subcategory['Article']['title'];
			$this->aBreadCrumbs = array(
				'/' => 'Home', 
				$this->Router->getDir('products') => 'Products', 
				$this->Router->catUrl('products', $this->subcategory['Category']) => $this->subcategory['Category']['title'],
				$page_title
			);
			
			$seo = null;
			if (!(isset($this->params['page']) && intval($this->params['page']) > 1)) {
				$this->set('relatedContent', $this->subcategory);
				$seo = $this->subcategory['Seo'];
			}
			$this->data['SEO'] = $this->Seo->defaultSeo($seo,
				'Каталог продукции '.$page_title,
				"каталог продукции {$page_title}, запчасти для тракторов {$page_title}, запчасти для спецтехники {$page_title}, запчасти для {$page_title}",
				"На нашем сайте вы можете приобрести лучшие запчасти {$page_title} в Белорусии. Низкие цены на спецтехнику, быстрая доставка по стране, диагностика, ремонт."
			);
			$this->pageTitle = $this->data['SEO']['title'];
		} elseif ($this->category) {
			$page_title = $this->category['Article']['title'];
			$this->aBreadCrumbs = array(
				'/' => 'Home', 
				$this->Router->getDir('products') => 'Products', 
				$page_title
			);
			$filter['Article.cat_id'] = $this->category['Article']['id'];
			
			$seo = null;
			if (!(isset($this->params['page']) && intval($this->params['page']) > 1)) {
				$this->set('relatedContent', $this->category);
				$seo = $this->category['Seo'];
			}
			$this->data['SEO'] = $this->Seo->defaultSeo($seo,
				'Каталог продукции '.$page_title,
				"каталог продукции {$page_title}, запчасти для тракторов {$page_title}, запчасти для спецтехники {$page_title}, запчасти для {$page_title}",
				"На нашем сайте вы можете приобрести лучшие запчасти {$page_title} в Белорусии. Низкие цены на спецтехнику, быстрая доставка по стране, диагностика, ремонт."
			);
			$this->pageTitle = $this->data['SEO']['title'];
		}

		$aFilters = $this->_getFilters($filter);
		$this->grid['Article']['conditions'] = array_merge($this->grid['Article']['conditions'], $aFilters['conditions']);
		
		$aArticles = $this->PCGrid->paginate('Article');
		$this->set('aArticles', $aArticles);
		$this->set('aFilters', $aFilters);
		$this->set('page_title', $page_title);
		
		$conditions = array('Brand.object_type' => 'brands');
		$brands = Set::combine($this->Brand->find('all', compact('conditions')), '{n}.Brand.id', '{n}');
		$this->set('brands', $brands);
		
		$prices_by = array();
		$prices_ru = array();
		$prices2_ru = array();
		
		$ids = Set::extract($aArticles, '{n}.Article.id');
		
		$conditions = array(
			'param_id' => Configure::read('params.price_by'),
			'object_id' => $ids
		);
		$params = $this->ParamValue->find('all', compact('conditions'));
		if ($params) {
			$prices_by = Set::combine($params, '{n}.ParamValue.object_id', '{n}.ParamValue');
		}
		
		$conditions = array(
			'param_id' => Configure::read('params.price_ru'),
			'object_id' => $ids
		);
		$params = $this->ParamValue->find('all', compact('conditions'));
		if ($params) {
			$prices_ru = Set::combine($params, '{n}.ParamValue.object_id', '{n}.ParamValue');
		}
		
		$conditions = array(
			'param_id' => Configure::read('params.price2_ru'),
			'object_id' => $ids
		);
		$params = $this->ParamValue->find('all', compact('conditions'));
		if ($params) {
			$prices2_ru = Set::combine($params, '{n}.ParamValue.object_id', '{n}.ParamValue');
		}
		
		$this->set('prices_by', $prices_by);
		$this->set('prices_ru', $prices_ru);
		$this->set('prices2_ru', $prices2_ru);
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
			return $this->redirect('/404');
		}
		
		if ($this->params['category'] !== $aArticle['Category']['page_id'] 
				|| $this->params['subcategory'] !== $aArticle['Subcategory']['page_id']) {
			return $this->redirect($this->Router->url($aArticle));
		}
		
		$id = $aArticle['Article']['id'];
		
		unset($aArticle['Media']);
		$aArticle['Media'] = $this->MediaProduct->getMedia('Product', $aArticle['Article']['id']);
		$this->set('aArticle', $aArticle);

		$this->pageTitle = (isset($aArticle['Seo']['title']) && $aArticle['Seo']['title']) ? $aArticle['Seo']['title'] : $aArticle['Article']['title_rus'];
		$aArticle['Seo'] = $this->Seo->defaultSeo($aArticle['Seo'],
			$aArticle['Article']['title_rus'],
			$aArticle['Article']['title_rus'].", ".str_replace(',', ' ', $aArticle['Article']['title_rus'])." ".$aArticle['Category']['title'].", запчасти для спецтехники ".$aArticle['Category']['title'].", запчасти для ".$aArticle['Category']['title'],
			'На нашем сайте вы можете приобрести '.str_replace(',', ' ', $aArticle['Article']['title_rus']).' для трактора или спецтехники '.$aArticle['Category']['title'].' в Белорусии. Низкие цены на спецтехнику, быстрая доставка по стране, диагностика, ремонт.'
		);
		$this->data['SEO'] = $aArticle['Seo'];
		$aParamValues = $this->ParamValue->getValueOptions('ProductParam', $id);
		$this->set('aParamValues', Set::combine($aParamValues, '{n}.ParamValue.param_id', '{n}'));
		/*
		$aSimilar = $this->SiteProduct->find('all', array(
			'conditions' => array('Article.object_type' => 'products', 'Article.published' => 1, 'Article.object_id' => $aArticle['Article']['object_id'], 'Article.id <> ' => $id)
		));
		$this->set('aSimilar', $aSimilar);
		*/
		$this->aBreadCrumbs = array(
			'/' => 'Home', 
			$this->Router->getDir('products') => 'Products', 
			$this->Router->catUrl('products', $this->category['Article']) => $this->category['Article']['title'],
			$this->Router->catUrl('products', $this->subcategory['Article']) => $this->subcategory['Article']['title'],
			'View product'
		);
		
		$conditions = array('Brand.object_type' => 'brands', 'Brand.id' => $aArticle['Article']['brand_id']);
		$brand = $this->Brand->find('first', compact('conditions'));
		$this->set('brand', $brand);
	}

	private function _getFilters($filtersData) {
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
					$_value = str_replace(array('.', ' ', '-', ',', '/', '\\'), '', $value);
					
					// ищем запчасти по "марка TC, моторы TC, доп.инфа"
					$params_ids = implode(',', array(Configure::read('params.markaTS'), Configure::read('params.motorsTS'), Configure::read('params.dopInfa')));
					
					$conditions = array("param_id IN ({$params_ids}) AND (ParamValue.value LIKE '%{$value}%' OR ParamValue.value LIKE '%{$_value}%')");
					$products = $this->ParamValue->find('all', compact('conditions'));
					$product_ids = implode(',', ($products) ?  Set::extract($products, '{n}.ParamValue.object_id') : array(0));
					
					// поиск по общим номера деталей
					$numbers = explode(' ', str_replace(',', ' ', $_value));
					$ors = array();
					$order = array();
					$i = 0;
					$count = count($numbers);
					$_count = 0;
					while ($i < 100 && $count !== $_count) {
						$i++; // избегать бесконечный цикл
						foreach ($numbers as $key_ => $value_) {
							if (trim($value_) != ''){
								$ors[] = array('Article.detail_num LIKE "%'.trim($value_).'%"');
								$order[] = 'Article.detail_num LIKE "%'.trim($value_).'%" DESC';
							}
						}
						$products = $this->SiteProduct->find('all', array('conditions' => array('OR' => $ors)));
						foreach($products as $product) {
							$numbers = array_merge($numbers, explode(' ', str_replace(',', ' ', $product['Article']['detail_num'])));
						}
						$numbers = array_unique($numbers);
						$_count = $count;
						$count = count($numbers);
					}
					
					$ors = array(
						"Article.title LIKE '%{$value}%'", "Article.title LIKE '%{$_value}%'",
						"Article.title_rus LIKE '%{$value}%'", "Article.title_rus LIKE '%{$_value}%'",
						"Article.detail_num LIKE '%{$value}%'", "Article.detail_num LIKE '%{$_value}%'",
						"Article.id IN ({$product_ids})"
					);
					foreach ($numbers as $key_ => $value_) {
						if (trim($value_) != ''){
							$ors[] = 'Article.detail_num LIKE "%'.trim($value_).'%"';
						}
					}
					
					$aConditions[] = '('.implode(' OR ', $ors).')';
				} elseif ($key == 'Tag.id') {
					/*
					$aRows = $this->TagObject->find('list', array('fields' => array('TagObject.object_id', 'TagObject.object_type'), 'conditions' => array('TagObject.tag_id' => $value)));
					$aConditions['Article.id'] = array_keys($aRows);
					*/
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
