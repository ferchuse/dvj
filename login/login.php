<?phpheader("Content-Type: application/json");$response= array();include("../conexi.php");$link=Conectarse();$myusername=$_POST['id_usuarios'];$mypassword=$_POST['password']; // To protect mysqli injection (more detail about mysqli injection)$myusername = stripslashes($myusername);$mypassword = stripslashes($mypassword);/* $myusername = mysqli_real_escape_string($myusername);$mypassword = mysqli_real_escape_string($mypassword); */$sql="SELECT * FROM usuarios 	WHERE id_usuarios='$myusername' 	AND pass_usuarios='$mypassword'";$result=mysqli_query($link, $sql);	if (!$result){		 die('Error: ' . mysqli_error($link));	}$count=mysqli_num_rows($result);// Si la consulta devuelve 1 fila inicia la sesionif($count==1){	session_start();	session_regenerate_id(true);	$id_sesion = session_id();	$row = mysqli_fetch_assoc($result);	$id_usuario = $row["id_usuarios"];	$nombre_usuario= $row["nombre_usuarios"];	$_SESSION["id_usuarios"] = $id_usuario or die("Error al asignar id usuario");	//$_SESSION["usuario"] = $myusername or die("Error al iniciar variables de sesión");	$_SESSION["username"] = $nombre_usuario or die("Error al iniciar username");	$_SESSION["permisos"] = $row["permiso_usuarios"] or die("Error al iniciar permisos");	$response["login"] = "valid";	$response["permisos"] = $_SESSION["permisos"];		setcookie("id_usuarios", $id_usuario,  0, "/");	setcookie("permiso_usuarios", $row["permiso_usuarios"],  0, "/");	setcookie("nombre_usuarios", $nombre_usuario,  0, "/");	// setcookie("id_usuario", $id_usuario,  0, "/");}else{	$response["login"] = "invalid";	$response["mensaje"] = "Usuario y/o Contraseña Inválidos";}$response["query"] = $sql;echo json_encode($response);?>