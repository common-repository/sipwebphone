<?php
/*
Plugin Name: SIP phone Web
Plugin URI: http://www.hand4shake.com/
Version: 2.0
Author: Federico De Gioannini, <a href="http://www.xenialab.com/">XeniaLAB</a>
Description: SIP telephone web plugin. 
The SIP Web Phone Plugin allows you to add a Flash based SIP phone on your Wordpress Web site. The AJAX protocol allows the Flash phone to be easily integrated in the web page theme.
Once you have installed the plugin, you can access to a simple wordpress section in order to configure its parameters.
The SIP Web Phone works with many SIP standard proxy/registar (i.e. Asterisk) and let you to forward the calls wherever you prefer: for instance you can forward all the incoming calls to your company extension, your IVR or even your home or mobile phones...

IMPORTANT:

The AJAX popup works well in themes that don't lock the sidebar area, such as the default theme, dfblog or Simple Green.
In other situations the positioning of the plagin is wrong. In order to manage the positioning of the AJAX popup, you have to edit the file wpsipphone.php.
In particular, you have to change the value of leftOffset and topOffset that are defined as follow:

var leftOffset = scrolledX + centerX - 300;
var topOffset = scrolledY + centerY - 310;

This problem will be solved in future releases.

*/

//********************************
//            LICENSE
//********************************
/*

This software is distributed under GNU GPL license.
For more informations, please read the file "license.txt"

*/


//********************************
//		FUNCTIONS
//********************************

// action function for above hook
function SIPphone_add_pages() {
    
    // Add a new top-level menu 
    add_menu_page('SIP phone parameters', 'SIP phone', 'administrator', 'SIPphone-top-level-handle', 'SIPphone_toplevel_page', get_bloginfo('url').'/wp-content/plugins/sipwebphone/img/sipphone2.png');

}


// SIPphone_toplevel_page() displays the page content for the custom Test Toplevel menu
function SIPphone_toplevel_page() {

// Read in existing options value from database

    $telephone = get_option( 'telephone' );
    $tuser = get_option( 'user' );
    $tpassword = get_option( 'password' );
    $tmailbox = get_option( 'mailbox' );
    $tserver = get_option( 'server' );
    $tinterface = get_option( 'interface' );
    $tcall = get_option( 'number2call');

	

    // See if the user has posted us some information
    // If they did, this hidden field will be set to 'Y'
    if (( $_POST[ 'hf_telephone' ] == 'Y' ) || ( $_POST[ 'hf_user' ] == 'Y' ) || ( $_POST[ 'hf_password' ] == 'Y' ) || ( $_POST[ 'hf_mailbox' ] == 'Y' ) || ( $_POST[  'hf_server' ] == 'Y' ) || ( $_POST[ $hidden_field_name] == 'Y' ) || ( $_POST[ 'hf_interface' ] == 'Y' || ( $_POST[  'hf_number2call' ] == 'Y' ) )) {

        // Read their posted value
	
      	$telephone = stripslashes($_POST[ 'telephone' ]);	       
	$tuser = stripslashes($_POST[ 'user' ]);
	$tpassword = stripslashes($_POST[ 'password' ]);
        $tmailbox = stripslashes($_POST[ 'mailbox' ]);
        $tserver = stripslashes($_POST[ 'server' ]);
	$tcall = stripslashes($_POST[ 'number2call' ]);
	

	if (stripslashes($_POST[ 'interface' ]) == "")
			$tinterface = "http://share.hand4shake.com/h4sproject/webapps/sip/xphone1_2/";
		
		elseif (substr($_POST[ 'interface' ], -1) != "/")
			$tinterface = stripslashes($_POST[ 'interface' ]).'/';

		else
			$tinterface = stripslashes($_POST[ 'interface' ]);

	
        // Save the posted value in the database
        update_option( 'telephone' , $telephone );
        update_option( 'user' , $tuser );
	update_option( 'password' , $tpassword );
        update_option( 'mailbox' , $tmailbox );
        update_option( 'server' , $tserver );
	update_option( 'interface' , $tinterface );
        update_option( 'number2call' , $tcall );


if (file_exists(users)== FALSE)
	mkdir (users);

//Clean

$file = "user.xml";
if (file_exists($file)) {
 unlink ($file);
}


// .htaccess definition
	

if(preg_match("/^http:\/\/([^\/]*)\//",$tinterface,$arr))
	$ip=$arr[1];
else
	$ip=$tinterface;
$text = fopen("users/.htaccess", "w+");

$line = "order deny,allow\nDeny from all\nAllow from ".gethostbyname($ip);

fwrite($text, $line);
fclose($text); 


// XML definition	

$text = fopen("users/user.xml", "w+");

$line = '<?xml version="1.0"?>';
//fwrite($text, $line);

$line = "\n<config>\n	<telephone>$telephone</telephone>\n	<user>$tuser</user>\n	<password>$tpassword</password>\n	<mailbox>$tmailbox</mailbox>\n	<server>$tserver</server>\n	<t_number>$tcall</t_number>\n</config>";
fwrite($text, $line);

fclose($text);



        // Put an options updated message on the screen
?>
<div class="updated"><p><strong><?php _e('Options saved.', 'SIPphone_domain' ); ?></strong></p></div>
<?php

 }

    // Now display the options editing screen

    echo '<div class="wrap">';

    // header


    ?>  <a  style="float: left; title="SIP phone" rel="alternate" type="application/rss+xml" ><img src=" <?php echo get_bloginfo('url').'/wp-content/plugins/sipwebphone/img/sipphone.png' ?>" alt="" style="border:0" width="45" height="45"/></a>  <?php
    echo "<h2>"  . __( 'SIP phone parameters.', 'SIPphone_domain' ) . "</h2>";
    echo "<h4>" . __( 'Definition of the SIP account working parameters.', 'SIPphone_domain' ) . "</h4>";

    // options form
    
    ?>


<form name="form1" method="post" action="">
<input type="hidden" name="<?php echo 'hf_telephone'; ?>" value="Y">
<input type="hidden" name="<?php echo 'hf_user'; ?>" value="Y">
<input type="hidden" name="<?php echo 'hf_password'; ?>" value="Y">
<input type="hidden" name="<?php echo 'hf_mailbox'; ?>" value="Y">
<input type="hidden" name="<?php echo 'hf_server'; ?>" value="Y">
<input type="hidden" name="<?php echo 'hf_interface'; ?>" value="Y">
<input type="hidden" name="<?php echo 'hf_number2call'; ?>" value="Y">


<table class="form-table">
<tr>
<th><?php _e("Telephone Number:", 'SIPphone_domain' ); ?> </th>
<td><input type="text" name="<?php echo 'telephone'; ?>" value="<?php echo $telephone; ?>" size="20"></td>
</tr>

<tr>
<th><?php _e("Telephone User:", 'SIPphone_domain' ); ?> </th>
<td><input type="text" name="<?php echo 'user'; ?>" value="<?php echo $tuser; ?>" size="20"></td>
</tr>

<tr>
<th><?php _e("Telephone Password:", 'SIPphone_domain' ); ?> </th>
<td><input type="text" name="<?php echo 'password'; ?>" value="<?php echo $tpassword; ?>" size="20"></td>
</tr>

<tr>
<th><?php _e("Telephone Mailbox:", 'SIPphone_domain' ); ?> </th>
<td><input type="text" name="<?php echo 'mailbox'; ?>" value="<?php echo $tmailbox; ?>" size="20"></td>
</tr>

<tr>
<th><?php _e("Telephone Server:", 'SIPphone_domain' ); ?> </th>
<td><input type="text" name="<?php echo 'server'; ?>" value="<?php echo $tserver; ?>" size="40"></td>
</tr>

<tr>
<th><?php _e("Telephone Interface:", 'SIPphone_domain' ); ?> </th>
<td><input type="text" name="<?php echo 'interface'; ?>" value="<?php echo $tinterface; ?>" size="80"></td>
</tr>

<tr>
<th><?php _e("Telephone to call:", 'SIPphone_domain' ); ?> </th>
<td><input type="text" name="<?php echo 'number2call'; ?>" value="<?php echo $tcall; ?>" size="80"></td>
</tr>

</table>

<p class="submit">
<input type="submit" name="Submit" value="<?php _e('Update Options', 'SIPphone_domain' ) ?>" />
</p>

</form>
</div>

<?php

}


function check_numbers($val) {
   return preg_match("/^\d+$/",$val);
}




function widget_menu(){
  $data = get_option('phone_title');
  ?>
  <p><label>Title:  <input name="phone_title" type="text" value="<?php echo $data['title']; ?>" /></label></p>
  

  <?php

   if (isset($_POST['phone_title'])){
    $data['title'] = attribute_escape($_POST['phone_title']);
    update_option('phone_title', $data);
 
 }
}



function phone_widget() {
	
	$ptitle = get_option('phone_title');
	$ptitle = $ptitle['title'];

	echo"<h2>$ptitle</h2>";
	
	$telephone = get_option( 'telephone' );
        $tuser = get_option( 'user' );
        $tpassword = get_option( 'password' );
        $tmailbox = get_option( 'mailbox' );
        $tserver = get_option( 'server' );
	$tinterface = get_option( 'interface' );
	$taddress = get_bloginfo('url');
        $tcall = get_bloginfo('number2call');

?>

<script type='text/javascript'>
function myPopupRelocate() {
 var scrolledX, scrolledY, centerX, centerY;
 if( self.pageYOffset ) {
   scrolledX = self.pageXOffset ;
   scrolledY = self.pageYOffset;
   
 } else if( document.documentElement && document.documentElement.scrollTop ) {
   scrolledX = document.documentElement.scrollLeft;
   scrolledY = document.documentElement.scrollTop;
   } else if( document.body ) {
   scrolledX = document.body.scrollLeft;
   scrolledY = document.body.scrollTop;
   }

if( self.innerHeight ) {
  centerX = self.innerWidth;
  centerY = self.innerHeight;
} else if( document.documentElement && document.documentElement.clientHeight ) {
  centerX = document.documentElement.clientWidth;
  centerY = document.documentElement.clientHeight;
} else if( document.body ) {
  centerX = document.body.clientWidth;
  centerY = document.body.clientHeight;
}
 // We just add the scrolled amount to 5 (the desired padding)
 // to find the new coordinates

 var leftOffset = scrolledX + centerX - 280;
 var topOffset = scrolledY + centerY - 305;

 document.getElementById("mypopup").style.top = topOffset + "px";
 document.getElementById("mypopup").style.left = leftOffset + "px";
}

function fireMyPopup() {
 myPopupRelocate();
 document.getElementById("mypopup").style.display = "block";
 document.body.onscroll = myPopupRelocate;
 window.onscroll = myPopupRelocate;
}
</script>




<script>
function styledPopupClose() {
  document.getElementById("mypopup").style.display = "none";
}

</script>


<div id='mypopup' name='mypopup' style='position: absolute; width: 250px; height: 300px; display:none;  top: 150px; left: 50px;'>
<table width='250' cellpadding='0' cellspacing='0' border='0'>
<tr>
<td><img height='23' width='250' src='<?=$taddress?>/wp-content/plugins/sipwebphone/img/topbar.png' class='dragme'></td>
<td><a href='javascript:styledPopupClose();'><img height='23' width='24' src='<?=$taddress?>/wp-content/plugins/sipwebphone/img/close.png' border='0'></a></td>
</tr>
<tr><td colspan='2' style='background: #869ca7 no-repeat top left; width: 2500px; height: 277px; ' >

<script type="text/javascript">
function xphone_getConfig() {
	
	return {
		address: '<?=$taddress?>',
		flashserver: '<?=$tinterface?>',
		autologin: true 
	};
}

</script>
<div align="center">
<center>
  	<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"
			id="red5phone" width="215" height="235" align="middle"
			codebase="http://fpdownload.macromedia.com/get/flashplayer/current/swflash.cab">
			<param name="movie" value="<?=$tinterface?>red5phone.swf" />
			<param name="quality" value="high" />
			<param name="bgcolor" value="#869ca7" />
			<param name="allowScriptAccess" value="always" />
			<embed src="<?=$tinterface?>red5phone.swf" quality="high" bgcolor="#869ca7"
				width="215" height="235" name="red5phone" align="middle"
				play="true"
				loop="false"
				quality="high"
				allowScriptAccess="always"
				type="application/x-shockwave-flash"
				pluginspage="http://www.adobe.com/go/getflashplayer">
			</embed>
	</object>
</center>

</div>
</td></tr>
</table>
</div>

<center>
<input type='image' onClick='fireMyPopup()' src="<?=$taddress?>/wp-content/plugins/sipwebphone/img/click2call.png" width='100' height='100' >
</center>



<?php

}

function init_phone(){
	register_sidebar_widget('SIPphoneWeb', 'phone_widget');  
	register_widget_control('SIPphoneWeb', 'widget_menu');	
}



//*****************************************
//		ACTIONS
//*****************************************
add_action('admin_menu', 'SIPphone_add_pages');

add_action('plugins_loaded', 'init_phone');

?>