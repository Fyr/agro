<?
	$aItems = array();
	foreach($aMenu as $title => $link) {
		$_title = __(ucfirst($title), true);
		if ($title == $currMenu) {
			$aItems[] = '<a class="active" href="'.$link.'">'.$_title.'</a>';
		} else {
			$aItems[] = '<a href="'.$link.'">'.$_title.'</a>';
		}
	}
?>
<div class="adminMenu" align="center"><?=implode(' | ', $aItems)?></div>