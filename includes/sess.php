<?php

     function sess_open($sess_path, $sess_name) {
        
		
		return true;
    }

    function sess_close() {
		
			
        return true;
    }

    function sess_read($sess_id) {
	
        $result = mysql_query("SELECT session_data FROM table_session WHERE session_rnd_id = '$sess_id';");

		
        if (!mysql_num_rows($result)) {
		
            $CurrentTime = time();
			
            mysql_query("INSERT INTO table_session (session_rnd_id, session_date) VALUES ('$sess_id', $CurrentTime);");
            return '';
			
        } else {
			
            extract(mysql_fetch_array($result), EXTR_PREFIX_ALL, 'sess');
			
            mysql_query("UPDATE table_session SET session_date = $CurrentTime WHERE session_rnd_id = '$sess_id';");
			

		   return $sess_session_data;
        }
    }

    function sess_write($sess_id, $data) {

        $CurrentTime = time();
        mysql_query("UPDATE table_session SET session_data = '$data', session_date = $CurrentTime WHERE session_rnd_id = '$sess_id';");
        return true;
    }

    function sess_destroy($sess_id) {

        mysql_query("DELETE FROM table_session WHERE session_rnd_id = '$sess_id';");
		
		
        return true;
    }

    function sess_gc($sess_maxlifetime) {

        $CurrentTime = time();
        mysql_query("DELETE FROM table_session WHERE session_date + $sess_maxlifetime < $CurrentTime;");
        return true;
    }

    session_set_save_handler("sess_open", "sess_close", "sess_read", "sess_write", "sess_destroy", "sess_gc");


	
?>
