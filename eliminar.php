<?php require_once('Connections/CR7.php'); ?>
<?php
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = (!get_magic_quotes_gpc()) ? addslashes($theValue) : $theValue;

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}

if ((isset($_GET['id'])) && ($_GET['id'] != "")) {
  $deleteSQL = sprintf("DELETE FROM cr7 WHERE id=%s",
                       GetSQLValueString($_GET['id'], "int"));

  mysql_select_db($database_CR7, $CR7);
  $Result1 = mysql_query($deleteSQL, $CR7) or die(mysql_error());

  $deleteGoTo = "lista.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $deleteGoTo));
}

$colname_eliminar = "-1";
if (isset($_GET['id'])) {
  $colname_eliminar = (get_magic_quotes_gpc()) ? $_GET['id'] : addslashes($_GET['id']);
}
mysql_select_db($database_CR7, $CR7);
$query_eliminar = sprintf("SELECT * FROM cr7 WHERE id = %s", $colname_eliminar);
$eliminar = mysql_query($query_eliminar, $CR7) or die(mysql_error());
$row_eliminar = mysql_fetch_assoc($eliminar);
$totalRows_eliminar = mysql_num_rows($eliminar);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
</head>

<body>
<p>&iquest;estas seguro que desea eliminar? </p>
<p><?php echo $row_eliminar['id']; ?></p>
<p><?php echo $row_eliminar['producto']; ?></p>
<p><?php echo $row_eliminar['disponibles']; ?></p>
<p><?php echo $row_eliminar['precio']; ?></p>
<p><?php echo $row_eliminar['en_inventario']; ?></p>
<p><?php echo $row_eliminar['envios_a']; ?></p>
<p><?php echo $row_eliminar['tamanio_o_talla']; ?></p>
<p><?php echo $row_eliminar['colores_disponibles']; ?></p>
<p><?php echo $row_eliminar['personalizacion']; ?></p>
<p><?php echo $row_eliminar['contacto']; ?></p>
<form id="form1" name="form1" method="get" action="">
  <input name="oculto" type="hidden" id="oculto" value="<?php echo $row_eliminar['id']; ?>" />
  <label>
  <input type="submit" name="Submit" value="Enviar" />
</label>
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($eliminar);
?>