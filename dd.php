<?php 
error_reporting(E_ALL ^ E_NOTICE);
include "includes/config.php";


?>

<?php 
		$client = $_GET['client'];
		$project = $_GET['project'];
		$vert = $_GET['vert'];

	$verts = mysql_query("SELECT vertical_id, vertical_name FROM table_vertical WHERE vertical_id < 5 ORDER BY vertical_name ASC");	

	
	if($vert && !$client && !$project){
?>

	<option value='na'>Vertical Selection</option>
	
<?php	 while($qverts = mysql_fetch_object($verts)){ 
?>
	
				<option value="<?php echo $qverts->vertical_id; ?>"><?php echo $qverts->vertical_name; ?></option>

<?php
	 }
 
}
?>
		

	
<?php
		
		if($client && !$project){
?>		
			
		<option value=''>Client Selection</option>
<?php				
				$clients = mysql_query("SELECT client_id, client_name 
											FROM table_client, table_vertical, table_relation
											 
											WHERE vertical_id = r_vertical
											AND vertical_id= '{$vert}'
											AND client_id = r_client
											 
											GROUP BY client_id
											ORDER BY client_name ASC
											");
		
				while($qclients = mysql_fetch_object($clients)){
?>			
					
				<option value="<?php echo $qclients->client_id; ?>"><?php echo $qclients->client_name; ?></option>
				
				
<?php
				}
		
	
		}		
		
?>


<?php
		
	
		if($project){
?>		

		<option value=''>Project Selection</option>
<?php				
				$projects = mysql_query("SELECT project_id, project_name
 
															FROM table_project, table_client, table_vertical, table_relation
															 
															WHERE vertical_id = r_vertical
															AND vertical_id = '{$vert}'
															AND client_id = r_client
															AND client_id = '{$client}'
															AND project_id = r_project
															 
															GROUP BY project_id
															ORDER BY project_name ASC
															");
		
				while($qprojects = mysql_fetch_object($projects)){
?>			
					
				<option value="<?php echo $qprojects->project_id; ?>"><?php echo $qprojects->project_name; ?></option>
				
				
<?php
				}

		}		
		
?>

	
