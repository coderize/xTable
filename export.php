<?php 
ob_start();
require "includes/config.php"; 

$rel = mysql_real_escape_string($_GET['rel']);

$q = @mysql_query("SELECT manual_function_name AS 'FUNCTION'			
									, status_name as 'STATUS'
									, manual_tcid AS 'TCID'
									, priority_name AS 'PRIORITY'
									, class_name AS 'CLASS'
									, manual_name AS 'NAME'
									, manual_prereq AS 'PREREQUISITE'
									, manual_steps AS 'SCENARIO'
									, manual_expected AS 'VERIFICATION'
									 
									FROM table_manual, table_class, table_relation, table_priority, table_status
									 
									WHERE manual_relation_id = {$rel}
									AND manual_relation_id = relation_id
									AND manual_class_id = class_id
									AND manual_priority_id = priority_id
									AND manual_status = status_id
									
									ORDER BY status_name, manual_tcid
								
									"); 
/* $table = "<table>
		<th>FUNCTION</th>		
		<th>TCID</th> 
		<th>PRIORITY</th> 
		<th>CLASS</th> 
		<th>NAME</th> 
		<th>PREREQUISITE</th>
		<th>SCENARIO</th>
		<th>VERIFICATION</th>
		"; */

      while($query_row = @mysql_fetch_object($q))  {  	  
	  
		$table .= "<table><tr>
			   <td>$query_row->FUNCTION</td>
			   
			   <td>$query_row->TCID</td>
			   
			   <td>$query_row->PRIORITY</td>
			   
			   <td>$query_row->CLASS</td>
			   
			   <td>$query_row->NAME</td>
			  
			  <td><pre>$query_row->PREREQUISITE</pre></td>			   
			  
			   <td><pre>$query_row->SCENARIO</pre></td>			   
			   
			   <td><pre>$query_row->VERIFICATION</pre></td>			
			   
			</tr>";       
	   }
	   
	$table .= "</table>";
	
	echo $table;
	
ob_end_flush();
?>