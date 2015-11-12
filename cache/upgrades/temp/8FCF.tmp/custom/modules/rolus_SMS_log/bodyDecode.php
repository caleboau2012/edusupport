<?php
//Logic hook for scheduled messages
class bodyDecode {

		   function decoding64(&$bean, $event, $arguments) {
		if($bean->status=='scheduled'){
		$bean->message=base64_decode($bean->message);

		}

			    }
		}

?>
