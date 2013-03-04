--- include/classes/class.cwidget.php	2013-03-04 14:54:56.000000000 -0500
+++ include/classes/class.cwidget.php	2013-03-04 17:29:06.000000000 -0500
@@ -59,19 +59,13 @@
 			$this->css_class = $class;
 	}
 
-	public function addPageHeader($header, $headerright=SPACE){
+	public function addPageHeader($header=SPACE, $headerright=SPACE){
 		zbx_value2array($headerright);
-
-		if(is_null($header) && !is_null($headerright)) $header = SPACE;
-
 		$this->pageHeaders[] = array('left'=> $header, 'right'=>$headerright);
 	}
 
-	public function addHeader($header=null, $headerright = SPACE){
+	public function addHeader($header = SPACE, $headerright = SPACE){
 		zbx_value2array($headerright);
-
-		if(is_null($header) && !is_null($headerright)) $header = SPACE;
-
 		$this->headers[] = array('left'=> $header, 'right'=>$headerright);
 	}
 
@@ -171,12 +165,12 @@
 		$pageHeader = array();
 
 		foreach($this->pageHeaders as $num => $header){
-			$pageHeader[] = $this->createPageHeaderRow($header['left'], $header['right']);
+			$pageHeader[] = get_table_header($header['left'], $header['right']);
 		}
 
 		// $pageHeader[] = BR();
 
-	return $pageHeader;
+	return new CDiv($pageHeader);
 	}
 
 	private function createPageHeaderRow($col1, $col2=SPACE){
@@ -221,32 +215,26 @@
 	private function createHeader(){
 		$header = array_shift($this->headers);
 
-
-		$td_l = new CCol(SPACE);
-		$td_l->setAttribute('width','100%');
-
-		$right_row = array($td_l);
+		$right_row = array();
 
 		if(!is_null($header['right'])){
 			foreach($header['right'] as $num => $r_item)
-				$right_row[] = new CCol($r_item);
+				$right_row[] = new CDiv($r_item, 'floatright');
 		}
 
 		if(!is_null($this->state)){
 			$icon = new CIcon(S_SHOW.'/'.S_HIDE, $this->state?'arrowup':'arrowdown',
 					"change_hat_state(this,'".$this->domid."');");
 			$icon->setAttribute('id',$this->domid.'_icon');
-			$right_row[] = new CCol($icon);
+			$icon->setAttribute('class',$icon->getAttribute('class').' floatright');
+			$right_row[] = $icon;
 		}
 
-		$right_tab = new CTable(null,'nowrap');
-		$right_tab->setAttribute('width','100%');
-
-		$right_tab->addRow($right_row, 'textblackwhite');
-
-		$header['right'] = $right_tab;
+		if ($right_row) {
+		    $right_row = array_reverse($right_row);
+		}
 
-		$header_tab = new CTable(null,$this->css_class);
+		$header_tab = new CTable(null,$this->css_class.' maxwidth');
 		$header_tab->setCellSpacing(0);
 		$header_tab->setCellPadding(1);
 
@@ -254,9 +242,10 @@
 //			$header_tab->setAttribute('style','border-bottom: 0px;');
 		}
 
-		$header_tab->addRow($this->createHeaderRow($header['left'],$right_tab),'first');
+		$header_tab->addRow($this->createHeaderRow($header['left'],$right_row),'first');
 
 		foreach($this->headers as $num => $header){
+			if ($num > 0) continue;
 			$header_tab->addRow($this->createHeaderRow($header['left'],$header['right']), 'next');
 		}
 
