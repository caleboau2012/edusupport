<?php /* Smarty version 2.6.11, created on 2015-12-10 14:07:50
         compiled from include/MVC/View/tpls/xsrf.tpl */ ?>

<div align='center' style='background:lightgray'>
<h3 style='color:red'>Possible Cross Site Request Forgery (XSRF) Attack Detected</h3>
<h4>If you think this is a mistake please ask your administrator to add the following site to the acceptable referer list</h4>
<h3><?php echo $this->_tpl_vars['host']; ?>
</h3>
<h4><a href='javascript:void(0);' onclick='document.getElementById("directions").style.display="";'>Click here for directions to add this site to the acceptable referer list</a></h4>
</div>
<div id='directions' style='display:none'>
	<h3>Directions:</h3>
	<ol>
		<li>On your file system go to the root of your SugarCRM instance
		<li>Open the file config_override.php. If it does not exist, create it. (it should be at the same level as index.php and config.php)
		<li>Make sure the file starts with <pre>&lt;?php</pre> followed by a new line
		<li>Add the following line to your config_override.php file<br> <pre>$sugar_config['http_referer']['list'][] = '<?php echo $this->_tpl_vars['host']; ?>
';</pre>
		<li>Save the file and it should work
	</ol>
	<h3>Attempted action (<?php echo $this->_tpl_vars['action']; ?>
):</h3>
	If you feel this is a valid action that should be allowed from any referer, add the following to your config_override.php file
	<ul><li><pre>$sugar_config['http_referer']['actions'] =array( <?php echo $this->_tpl_vars['whiteListString']; ?>
 ); </pre></ul>
</div>