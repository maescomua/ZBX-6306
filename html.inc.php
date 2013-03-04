--- include/html.inc.php	2013-03-04 17:12:53.000000000 -0500
+++ include/html.inc.php	2013-03-04 17:20:39.000000000 -0500
@@ -206,32 +206,22 @@
 			if(($col1 == SPACE) && ($col2 == SPACE)) return new CJSscript('');
 		}
 
-		$td_l = new CCol(SPACE,'header_r');
-		$td_l->setAttribute('width','100%');
-
-		$right_row = array($td_l);
-
-		if(!is_null($col2)){
+		$right_row = array();
+		if($col2){
 			if(!is_array($col2)) $col2 = array($col2);
 
 			foreach($col2 as $num => $r_item)
-				$right_row[] = new CCol($r_item,'header_r');
+				$right_row[] = new CDiv($r_item,'floatright');
 		}
 
-		$right_tab = new CTable(null,'nowrap');
-		$right_tab->setAttribute('width','100%');
+		$right_row = array_reverse($right_row);
 
-		$right_tab->addRow($right_row);
-
-		$table = new CTable(NULL,'header');
+		$table = new CTable(NULL,'ui-widget-header ui-corner-all header maxwidth');
 //		$table->setAttribute('border',0);
 		$table->setCellSpacing(0);
 		$table->setCellPadding(1);
 
-		$td_r = new CCol($right_tab,'header_r');
-		$td_r->setAttribute('align','right');
-
-		$table->addRow(array(new CCol($col1,'header_l'), $td_r));
+		$table->addRow(array(new CCol($col1, 'header_l left'), new CCol($right_row, 'header_r right')));
 	return $table;
 	}
 
