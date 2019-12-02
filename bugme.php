<?php
//sql server login
$servername = "localhost";
$dBUsername = "root";
$dBPassword = "";
$dBName = "user_db";

$conn = mysqli_connect($servername, $dBUsername, $dBPassword, $dBName);

if (!$conn) {
	die("connection failed".mysql_connect_error());
}
date_default_timezone_set("America/New_York");


//request calculation
if(!empty($_REQUEST["request"])){
	if (session_status() == PHP_SESSION_NONE) {
    		session_start();
		}
	$request = $_REQUEST["request"];
	if ($request == 'login') {
		login();
	}
	elseif ($request == 'home') {
		if (isset($_SESSION['id']) && isset($_SESSION['email'])) {
			$fil=$_REQUEST['filter'];
			alltickets($fil);
		}
	}
	elseif ($request == 'logout') {
		logout('');
	}
	elseif ($request == 'sIssueform') {
		submitIssueform('');
	}
	elseif ($request == 'submitIssue') {
		submitIssue();
	}
	elseif ($request == 'viewIssue') {
		viewIssue();
	}
	elseif ($request == 'update') {
		update();
	}

	elseif (isset($_SESSION['id']) && isset($_SESSION['email'])) {
		if ($request == 'adduserform' || $request == 'adduser') {
			if ($_SESSION['id']==1 && ($_SESSION['email']=='admin@bugme.com')) {
				if ($request == 'adduserform'){adduserform('');}
				elseif ($request == 'adduser') {adduser();}
				else{echo "Error";}
				
			}
		}
		
		
	}
	
	else{
		echo 'wrong';
	}
}
//home page
function alltickets($filterT){
	$host = getenv('IP');
	$username = 'root';
	$password = '';
	$dbname = 'user_db';
	$sconn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
	if ($filterT=='all') {
		$sql=$sconn->query("SELECT issues.id, title, type, statusOI, firstname, lastname, created_D FROM issues JOIN users ON assigned_to=users.id ORDER BY created_D DESC, created_T DESC");
		$results =$sql->fetchAll(PDO::FETCH_ASSOC);
	}
	elseif ($filterT=='open') {
		$sql=$sconn->query("SELECT issues.id, title, type, statusOI, firstname, lastname, created_D FROM issues JOIN users ON assigned_to=users.id WHERE statusOI='Open' ORDER BY created_D DESC, created_T DESC");
		$results =$sql->fetchAll(PDO::FETCH_ASSOC);
	}
	elseif ($filterT=='my tickets') {
		$sql=$sconn->query("SELECT issues.id, title, type, statusOI, firstname, lastname, created_D FROM issues JOIN users ON assigned_to=users.id WHERE issues.created_by=".$_SESSION['id']." ORDER BY created_D DESC, created_T DESC");
		$results =$sql->fetchAll(PDO::FETCH_ASSOC);
	}
	else{echo "ERROR";}


		?>
		<div class="grid-container-full-page">

			<div class="menu">
				<ul>
					<li>
						<button type "button" class="navbtn" id="home" onclick="home('all')">Home</button>
					</li>
					<li>
						<?php if ($_SESSION['id']==1 && ($_SESSION['email']=='admin@bugme.com')) {
						?>
						<button type "button" class="navbtn" id="add-user" onclick="addUserform('')">Add User</button>
						<?php
						}?>
				
					</li>
					<li>
						<button type="button" class="navbtn" id="new-issue" onclick="sIssueform('')">New Issue</button>
					</li>
					<li>
						<button type="button" class="navbtn" id="logout" onclick="logout('')">Logout</button>
					</li>
				</ul>

				
				

			</div>
			<div class="main-content" id="main-c">
				<div class="header-table-page">
					
					<h2 class="header-title">Issues</h2>
				
					<button type="button" class="subbutton" id="create-Issue" onclick="sIssueform()"> Create New Issue</button>
					
				</div>
				<div class="table-all">
					<div class="filter">
						<div><h3 class="filterheader">Filter by:</h3></div>
						<div>
							<button type "button" class="tablebtn" id="all" onclick="home('all')">ALL</button>
							<button type "button" class="tablebtn" id="open" onclick="home('open')">OPEN</button>
							<button type "button" class="tablebtn" id="myticks" onclick="home('my tickets')">MY TICKETS</button>
						</div>
					</div>
					<table class="table1">
						<thead>
							<th>Title</th>
    						<th>Type</th>
    						<th>Status</th>
    						<th>Assigned To </th>
    						<th>Created</th>
    					</thead>
    					<tbody class="scroll">
    						<?php if ($results!==null) {
    							foreach ($results as $row):
    						?>
    						<tr id = "<?=$row['id'];?>" onclick="viewIssue(<?=$row['id'];?>)">
  								<td><p class=id>#<?=$row['id'];?> <?=$row['title'];?></p></td>
  								<td><?=$row['type'];?></td>
  								<td class="<?=$row['statusOI'];?>"><span><?=$row['statusOI'];?></span></td>
  								<td><?=$row['firstname'];?> <?=$row['lastname'];?></td>
  								<td><?=$row['created_D'];?></td>
							</tr>
					
							<?php endforeach; } ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		
		<?php
	$sconn=null;
	exit();
}

//add user form
function adduserform($errormsg){
	if ($_SESSION['id']==1 && ($_SESSION['email']=='admin@bugme.com')) {
		?>
		<div class="form">
			<h2>Sign Up User</h2>
			<?php print($errormsg) ;?>    
			<form action="" method="post">
				<ul class="nav">
					<li>
						<label class="form" for="firstname"><b>First Name:</b></label>
					</li>
					<li>
						<input type="text" class="input" id="firstname" placeholder="First Name">
					</li>
					<li>
						<label class="form" for="lastname"><b>Last Name:</b></label>
					</li>
					<li>
						<input type="text" class="input" id="lastname" placeholder="Last Name">
				
					</li>
					<li>
						<label class="form" for="email"><b>Email:</b></label>
					</li>
					<li>
						<input type="text" class="input" id="email" placeholder="E-mail">
				
					</li>
					<li>
						<label class="form" for="pwd"><b>Password:</b></label>
					</li>
					<li>
						<input type="password" class="input" id="pwd" placeholder="Password">
				
					</li>
					<li>
						<label class="form" for="pwd-repeat"><b>Confirm Password:</b></label>
					</li>
					<li>
						<input type="password" class="input" id="pwd-repeat" placeholder="Confirm Password">
				
					</li>
				</ul>
				<button type="button" class="subbutton" id="adduserbtn" onclick="addUser()">Add User</button>
			</form>
		</div>
		<?php
	}
}
//add user process
function adduser() {
	

	$firstname = $_REQUEST['firstname'];
	$lastname = $_REQUEST['lastname'];
	$email = $_REQUEST['email'];
	$pwd = $_REQUEST['pwd'];
	$pwdRepeat = $_REQUEST['pwd-repeat'];
	$dateJoin = date("Y-m-d");

	if (empty($firstname) || empty($lastname) ||empty($email) ||empty($pwd) ||empty($pwdRepeat)) {
		errorh(2,"There are Empty Fields.");
		exit();
		
	}

	elseif (!filter_var($email,FILTER_VALIDATE_EMAIL)) {
		errorh(2,"Invaild Email.");
		exit();
	}
	elseif (!preg_match("/^(?=.*[a-z])(?=.*[0-9])(?=.*[A-Z])([a-zA-Z0-9]){8,}$/",$pwd )) {
		errorh(2,"Invaild Password. \nPassword must be atleast 8 characters long and must\n
		 		have aleast 1 captial letter, 1 common letter and 1 nubmer.\n 
		 		<br>Special Characters are NOT ALLOWED.");
		exit();

	}
	elseif ($pwd !== $pwdRepeat) {
		errorh(2,"Passwords must match.");
		exit();
	}
	else{

		$sql = "SELECT email FROM users WHERE email=?";
		$stmt = mysqli_stmt_init($GLOBALS['conn']);
		if (!mysqli_stmt_prepare($stmt,$sql)) {
			echo("Location: ../signup.php?error=sqlerror1");
		exit();
		}
		else{
			mysqli_stmt_bind_param($stmt,"s",$email);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_store_result($stmt);
			$resultCheck = mysqli_stmt_num_rows($stmt);
			if ($resultCheck > 0) {
				errorh(2,"Email is already taken.");
				exit();
			}
			else{
				$sql = "INSERT INTO users (firstname, lastname, pwd, email, date_joined) VALUES (?,?,?,?,?)";
				$stmt = mysqli_stmt_init($GLOBALS['conn']);
				if (!mysqli_stmt_prepare($stmt,$sql)) {
					echo("Location: ../signup.php?error=sqlerror2");
					exit();
				}
				else{
					$hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);

					mysqli_stmt_bind_param($stmt,"sssss", $firstname, $lastname, $hashedPwd, $email, $dateJoin);
					mysqli_stmt_execute($stmt);
					mysqli_stmt_store_result($stmt);
					alltickets('all');
					exit();
				}
			}
		}
	}
	mysqli_stmt_close($stmt);
	mysqli_close($GLOBALS['conn']);	
}


//logout process
function logout($errormsg){
	if (session_status() == PHP_SESSION_NONE) {
    	session_start();
	}
	session_unset();
	session_destroy();?>

	
	<header class="heading">
        <h2> Login </h2>
    </header>
    <?php print($errormsg) ;?>            
    <div class="loginform">
       	<form >
       		<ul>
       			<li>
       				<label for="uname"><b>Username</b></label>
            		<input class="inputlogin" type="text" placeholder="email..." Id="email" class="uname" required>
       			</li>
            	<li>
            		<label for="psw"><b>Password</b></label>
            		<input class="inputlogin" type="password" placeholder="password..." id="pwd" class="psd" >
            	</li>
          	</ul>
        </form>
        <button type="button" class="subbutton" id="login" onclick="login()"> Login </button>
    </div>
   

	<?php 
}


//login process
function login () {

	$email = $_REQUEST['email'];
	$pwd = $_REQUEST['password'];

	if (empty($email) && empty($pwd)) {
		errorh(1,"Empty Email and Password Fields");
		exit();

	}
	elseif (empty($email)) {
		errorh(1,"Empty Email Field");
		exit();
	}
	elseif (empty($pwd)) {
		errorh(1,"Empty Password Field");
		exit();
	}
	else{
		$sql = "SELECT * FROM users WHERE email=?;";
		$stmt = mysqli_stmt_init($GLOBALS['conn']);
		if (!mysqli_stmt_prepare($stmt,$sql)) {
			echo("Location: ../index.php?error=sqlerror");
			exit();
		}
		else{

			mysqli_stmt_bind_param($stmt,"s", $email);
			mysqli_stmt_execute($stmt);
			$result = mysqli_stmt_get_result($stmt);

			if ($row = mysqli_fetch_assoc($result)) {
				$pwd_Check=password_verify($pwd, $row['pwd']);
				if ($pwd_Check == false) {
					errorh(1,"Incorrect Username or Password");
					exit();
				}
				else if ($pwd_Check == true) {

					if (session_status() == PHP_SESSION_NONE) {
    					session_start();
					}	
					$_SESSION['id'] = $row['id'];
					$_SESSION['email'] = $row['email'];
					alltickets('all');
					
					}
					exit();
				}
			else{
					errorh(1,"Incorrect Username or Password");
					exit();
			}

		}
			
	}
}


/* Admin check
if (isset($_SESSION['id']) && isset($_SESSION['email'])) {
	if ($_SESSION['id']==1 && isset($_SESSION['email']=='admin@bugme.com')) {
		# code...
	}	
}*/

// submit issue form
function submitIssueform($errormsg){
	$host = getenv('IP');
	$username = 'root';
	$password = '';
	$dbname = 'user_db';

	$sconn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);

	$sql=$sconn->query("SELECT * FROM users;") ;
	$results =$sql->fetchAll(PDO::FETCH_ASSOC);
	
		if (isset($_SESSION['id']) && isset($_SESSION['email'])){
 
			?>

				<div class="adduserform">
					<h2>Submit Issue</h2>
					<?php print($errormsg) ;?>  
					<form action="" method="post">
						<ul>
							<li>
								<label class="form" for="title"><b>Title:</b></label>
							</li>
							<li>
								<input type="text" class="input" id="title" placeholder="Title..">
							</li>
							<li>
								<label class="form" for="title"><b>Description:</b></label>
							</li>
							<li>
								<input type="text" class="input" id="desc" placeholder="Description..">
							</li>
							<li>
								<label class="form" for="assigned"><b>Assign to:</b></label>
							</li>
							<li>
								<select class="inputselect" id="assigned">
									<?php if ($results!==null) {
    									foreach ($results as $row):
    								?>

									<option value=<?=$row['id'];?>><?=$row['firstname'];?> <?=$row['lastname'];?></option>
									<?php endforeach; } ?>
								</select>
							</li>
							<li>
								<label class="form" for="type"><b>Type:</b></label>
							</li>
							<li>
								<select class="inputselect" id="type">
									<option>
										Bug
									</option>
									<option>
								 		Proposal
									</option>
									<option>
										Task
									</option>
								</select>
							</li>
							<li>
								<label class="form" for="priority"><b>Priority:</b></label>
							</li>
							<li>
								<select class="inputselect" id="priority">
									<option>
										Minor
									</option>
									<option>
										Major
									</option>
									<option>
										Critical
									</option>
								</select>
							</li>
						</ul>
						
						
						
						

						
						<button type="button" id="subissuebtn" class="subbutton" onclick="submitIssue()">Submit issue	
						</button>
					</form>

				</div>



			<?php
			$sconn=null;
		}	
}

// submit issue process
function submitIssue () {
	
	$title = $_REQUEST['title'];
	$desc = $_REQUEST['desc'];
	$type = $_REQUEST['type'];
	$priority = $_REQUEST['priority'];
	$assign = intval($_REQUEST['assigned']);
	$date = date("Y-m-d ");
	$time =date("h:i:sa");
	$statusOI='Open';

	



	if (empty($title) && empty($desc) ) {
		errorh(3,"Empty Title and Description Fields");
		exit();
	}
	elseif (empty($title) ) {
		errorh(3,"Empty Title Field");
		exit();
	}
	elseif (empty($desc) ) {
		errorh(3,"Empty Title Description");
		exit();
	}
	else{
		$sql= "INSERT INTO issues (title, description, type, priority, statusOI, assigned_to, created_by, created_D, created_T, updated_D, updated_T) VALUES(?,?,?,?,?,?,?,?,?,?,?);";
		$stmt = mysqli_stmt_init($GLOBALS['conn']);
		if (!mysqli_stmt_prepare($stmt,$sql)) {
			echo("Location: ../signup.php?error=sqlerror11");
			exit();
		}
		else{
			
			mysqli_stmt_bind_param($stmt,"sssssiissss", $title, $desc, $type, $priority,$statusOI, $assign, $_SESSION['id'], $date, $time, $date, $time);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_store_result($stmt);
			alltickets('all');
			exit();

		}

	}	
}


//display ticket
function viewIssue () {
	$id = $_REQUEST['id'];

	$host = getenv('IP');
	$username = 'root';
	$password = '';
	$dbname = 'user_db';

	$sconn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);

	$sql=$sconn->query("SELECT issues.id, title, description, type, priority, statusOI, assigned_to, created_by, created_D, created_T, updated_D, updated_T, firstname, lastname FROM issues JOIN users ON assigned_to=users.id WHERE issues.id =".$id);
	$results =$sql->fetch();
	$nsql=$sconn->query("SELECT * FROM users WHERE id = ".$results['created_by']);
	$nresults=$nsql->fetch();
	?>
	<div class="ticket">
		<div class="ticketHeader">
				<h2 class="ticketTitle"><?=$results['title'];?></h2>
				<h3 class="ticketID">Issue #<?=$results['id'];?></h3>
		</div>
		<div class="ticket-cont">
			<div>
				<p><?=$results['description'];?></p>
				<ul class="arrowD-T">
					<li> 
						<pt class="colorD-T">Issue created on <?php print(date("M j, Y", strtotime($results['created_D'])));?> at <?=$results['created_T'];?> by <?=$nresults['firstname'];?> <?=$nresults['lastname'];?></pt>
						
					</li>
					<li>
						<pt class="colorD-T">Last updated on <?php print(date("M j, Y", strtotime($results['updated_D'])));?> at <?=$results['updated_T'];?></pt>
					</li>
				</ul>

			</div>
		
			<div class="ticket-cont-side">
				<ul>
					<li>
						<div>
							<div class="otherstats">Assigned To:</div>
							<?=$results['firstname'];?> <?=$results['lastname'];?>
						</div>
						
					</li>

					<li>
						<div>
							<div class="otherstats">Type:</div>
							<?=$results['type'];?>
						</div>
						
					</li>

					<li>
						<div>
							<div class="otherstats">Priority:</div>
							<?=$results['priority'];?>
						</div>
					</li>

					<li>
						<div>
							<div class="otherstats">Status:</div>
							<?=$results['statusOI'];?>
						</div>
							
					</li>
				</ul>
				<button type="button" class="subbutton" id="butClosed" onclick="update_stat(<?=$results['id'];?>,'Closed')"> Mark as Closed</button>
				<button type="button" class="subbutton" id="butInProgress" onclick="update_stat(<?=$results['id'];?>,'In Progress')">Mark In Progress</button>
			</div>
		</div>
	</div>
	
	<?php 
	$sconn=null;	
}

function update(){
	$id = $_REQUEST['id'];
	$date = date("Y-m-d ");
	$time =date("h:i:sa");
	$updat = $_REQUEST['updat'];
	$sql="UPDATE issues SET statusOI= ?,updated_D=?, updated_T=?  WHERE issues.id =".$id;
	$stmt = mysqli_stmt_init($GLOBALS['conn']);
				if (!mysqli_stmt_prepare($stmt,$sql)) {
					echo("Location: ../signup.php?error=sqlerror2");
					exit();
				}
				else{
					mysqli_stmt_bind_param($stmt,"sss", $updat,$date,$time);
					mysqli_stmt_execute($stmt);
					mysqli_stmt_store_result($stmt);
					alltickets('all');
					}
}

//error handler
function errorh($errorpg,$errormsg){
	if ($errormsg=='') {
		exit();
	}
	else{
		$errormsg ='<p class="error">'.$errormsg.'</p>';
		if ($errorpg ==1) {
			logout($errormsg);
			exit();
		}
		else{

			?>
		<div class="grid-container-full-page">

			<div class="menu">
				<ul>
					<li>
						<button type "button" class="navbtn" id="home" onclick="home('all')">Home</button>
					</li>
					<li>
						<?php if ($_SESSION['id']==1 && ($_SESSION['email']=='admin@bugme.com')) {
						?>
						<button type "button" class="navbtn" id="add-user" onclick="addUserform('')">Add User</button>
						<?php
						}?>
				
					</li>
					<li>
						<button type="button" class="navbtn" id="new-issue" onclick="sIssueform('')">New Issue</button>
					</li>
					<li>
						<button type="button" class="navbtn" id="logout" onclick="logout('')">Logout</button>
					</li>
				</ul>

				
				

			</div>
			<div class="main-content" id="main-c">
				
			<?php

			if ($errorpg ==2) {
				adduserform($errormsg);
				exit();
			}
			elseif ($errorpg ==3) {
				submitIssueform ($errormsg);
				exit();

			}?>

			</div>
		</div>
			<?php
		}

	}
}