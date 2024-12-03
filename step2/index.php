
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Super friend page</title>
    <style type="text/css" media="screen">
  * {
    margin: 0px 0px 0px 0px;
    padding: 0px 0px 0px 0px;
  }

  body, html {
    padding: 3px 3px 3px 3px;

    background-color: #D8DBE2;

    font-family: Verdana, sans-serif;
    font-size: 11pt;
    text-align: center;
  }

  div.main_page {
    position: relative;
    display: table;

    width: 800px;

    margin-bottom: 3px;
    margin-left: auto;
    margin-right: auto;
    padding: 0px 0px 0px 0px;

    border-width: 2px;
    border-color: #212738;
    border-style: solid;

    background-color: #FFFFFF;

    text-align: center;
  }

  div.page_header {
    height: 99px;
    width: 100%;

    background-color: #F5F6F7;
  }

  div.page_header span {
    margin: 15px 0px 0px 50px;

    font-size: 180%;
    font-weight: bold;
  }

  div.page_header img {
    margin: 3px 0px 0px 40px;

    border: 0px 0px 0px;
  }

  div.table_of_contents {
    clear: left;

    min-width: 200px;

    margin: 3px 3px 3px 3px;

    background-color: #FFFFFF;

    text-align: left;
  }

  div.table_of_contents_item {
    clear: left;

    width: 100%;

    margin: 4px 0px 0px 0px;

    background-color: #FFFFFF;

    color: #000000;
    text-align: left;
  }

  div.table_of_contents_item a {
    margin: 6px 0px 0px 6px;
  }

  div.content_section {
    margin: 3px 3px 3px 3px;

    background-color: #FFFFFF;

    text-align: left;
  }

  div.content_section_text {
    padding: 4px 8px 4px 8px;

    color: #000000;
    font-size: 100%;
  }

  div.content_section_text pre {
    margin: 8px 0px 8px 0px;
    padding: 8px 8px 8px 8px;

    border-width: 1px;
    border-style: dotted;
    border-color: #000000;

    background-color: #F5F6F7;

    font-style: italic;
  }

  div.content_section_text p {
    margin-bottom: 6px;
  }

  div.content_section_text ul, div.content_section_text li {
    padding: 4px 8px 4px 16px;
  }

  div.section_header {
    padding: 3px 6px 3px 6px;

    background-color: #8E9CB2;

    color: #FFFFFF;
    font-weight: bold;
    font-size: 112%;
    text-align: center;
  }

  div.section_header_red {
    background-color: #CD214F;
  }

  div.section_header_grey {
    background-color: #9F9386;
  }

  .floating_element {
    position: relative;
    float: left;
  }

  div.table_of_contents_item a,
  div.content_section_text a {
    text-decoration: none;
    font-weight: bold;
  }

  div.table_of_contents_item a:link,
  div.table_of_contents_item a:visited,
  div.table_of_contents_item a:active {
    color: #000000;
  }

  div.table_of_contents_item a:hover {
    background-color: #000000;

    color: #FFFFFF;
  }

  div.content_section_text a:link,
  div.content_section_text a:visited,
   div.content_section_text a:active {
    background-color: #DCDFE6;

    color: #000000;
  }

  div.content_section_text a:hover {
    background-color: #000000;

    color: #DCDFE6;
  }

  div.validator {
  }
    </style>
  </head>
  <body>
        
        <?php
        	$wrongAuth = false;
        	$auth = false;

		/* Check auth */
		if(isset($_GET["user"]) && isset($_GET["mdp"])){
			$user = $_GET["user"];
			$mdp = $_GET["mdp"];
			
			/* Test the entry */
			$req = "grep -P '^".$user."\t[0-9]+\t".$mdp."$' mdp.txt";
			$res = exec($req); // Stupid method
			if(!empty($res)){
				$auth = true;
			} else {
				$wrongAuth = true;
			}
		} 
		
		if($wrongAuth){
			echo " <div class='section_header section_header_red'>
			          Wrong password for $user!
			     </div> ";
			        
		}
		
		if (!$auth) { 
		 	echo " <div class='section_header section_header_red'>
			          You must be logged to search for a friend
			        </div> ";
			        
			echo " <form method='GET' action='index.php'>
					User name : <input type='text' name='user' value='' size='30' maxlength='50'/> <br>
					Password (< 4 char) : <input type='password' name='mdp' value='' size='30' maxlength='4' /> <br>
					Friend name : <input type='text' name='friend' value='' size='30' maxlength='50'/> <br>
					<input type='submit' value='OK' />
				</form>
			 ";
		} else {/* Auth Ok */
			
			/* Look for friend */
			$n = 0;
			$friend = "";
			if(isset($_GET["friend"]) && !empty($_GET["friend"])){
				$friend = $_GET["friend"];
				/* Test the entry */
				$req = "grep -P '^".$friend."\t*' mdp.txt | wc -l";
				$n = exec($req); // Stupid method
				if($n != "0"){
					$req = "cat mdp.txt | grep -oP '^".$friend."\t.+\t'  | grep -oP '\t.*\t$' | grep -oP '[^\t]*' ";
					$age = exec($req); // Stupid method	.
				}
			}
						
			/* Echo res */
			echo "<div class='section_header section_header_red'>
				<p> Hello $user </p> "; 
		 	/* Logout button */
			echo " <form action='index.php'>
					<input type='submit' value='Logout' />
			</form>
		 ";

			if(isset($_GET["friend"])){
				echo  "	<p> I know \"$n\" people named \"$friend\"</p>";
			}	
			if($n != "0"){
				echo "<p> One is $age years old !</p> ";
			}
			echo  "	</div>";
			/* Add user */
				
			echo " <form method='GET' action='index.php'>
					You can add new users by filling the following form :
					<input type='hidden' name='user' value='$user'/> <br>
					<input type='hidden' name='mdp' value='$mdp'/> <br>
					User name to add : <input type='text' name='userADD' value='' size='30' maxlength='50'/> <br>
					User to add age : <input type='text' name='ageADD' value='' size='30' maxlength='50'/> <br>
					Password to add (< 4 char) : <input type='password' name='mdpADD' value='' size='30' maxlength='4' /> <br>
					<input type='submit' value='OK' />
			</form>
		 ";

			if(isset($_GET["userADD"]) && isset($_GET["mdpADD"]) && isset($_GET["ageADD"])){
				$userADD = $_GET["userADD"];
				$ageADD = $_GET["ageADD"];
				$mdpADD = $_GET["mdpADD"];
			
				/* Test the entry */
				$req = "echo '".$userADD."\t".$ageADD."\t".$mdpADD."' >> mdp.txt";
				$res = passthru($req); // Stupid method
	
				echo "<div class='section_header section_header_red'>
					<p> Add new user \"$userADD\" OK </p>
					</div>";
		

			} 


		}
		
   	?>
  </body>
</html>

