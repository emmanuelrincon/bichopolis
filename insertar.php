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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO cr7 (id, producto, disponibles, precio, en_inventario, envios_a, tamanio_o_talla, colores_disponibles, personalizacion, contacto) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id'], "int"),
                       GetSQLValueString($_POST['producto'], "text"),
                       GetSQLValueString($_POST['disponibles'], "text"),
                       GetSQLValueString($_POST['precio'], "text"),
                       GetSQLValueString($_POST['en_inventario'], "text"),
                       GetSQLValueString($_POST['envios_a'], "text"),
                       GetSQLValueString($_POST['tamanio_o_talla'], "text"),
                       GetSQLValueString($_POST['colores_disponibles'], "text"),
                       GetSQLValueString($_POST['personalizacion'], "text"),
                       GetSQLValueString($_POST['contacto'], "text"));

  mysql_select_db($database_CR7, $CR7);
  $Result1 = mysql_query($insertSQL, $CR7) or die(mysql_error());

  $insertGoTo = "index.html";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_CR7, $CR7);
$query_insertar = "SELECT * FROM cr7";
$insertar = mysql_query($query_insertar, $CR7) or die(mysql_error());
$row_insertar = mysql_fetch_assoc($insertar);
$totalRows_insertar = mysql_num_rows($insertar);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
</head>

<body>
<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table align="center">
    <tr valign="baseline">
      <td nowrap align="right">Id:</td>
      <td><input type="text" name="id" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Producto:</td>
      <td><input type="text" name="producto" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Disponibles:</td>
      <td><input type="text" name="disponibles" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Precio:</td>
      <td><input type="text" name="precio" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">En_inventario:</td>
      <td><input type="text" name="en_inventario" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Envios_a:</td>
      <td><input type="text" name="envios_a" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Tamanio_o_talla:</td>
      <td><input type="text" name="tamanio_o_talla" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Colores_disponibles:</td>
      <td><input type="text" name="colores_disponibles" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Personalizacion:</td>
      <td><input type="text" name="personalizacion" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Contacto:</td>
      <td><input type="text" name="contacto" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><input type="submit" value="Insertar registro"></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1">
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($insertar);
?>
