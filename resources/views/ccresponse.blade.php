
    <?php 
     $success_response = $order_status;
    ?>
    
	<script>
      
      window.ReactNativeWebView.postMessage('<?php echo $success_response;?>');
    </script>
