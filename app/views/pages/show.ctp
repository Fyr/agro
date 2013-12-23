					<div class="area">
						<?=$this->element('title', array('title' => $aArticle['Article']['title']))?>
						<div class="text">
							<?=$this->HtmlArticle->fulltext($aArticle['Article']['body'])?>
						</div>
					</div>
