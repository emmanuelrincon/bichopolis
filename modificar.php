<?php require_once('Connections/CR7.php'); ?>
<?php
$currentPage = $_SERVER["PHP_SELF"];

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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE cr7 SET producto=%s, disponibles=%s, precio=%s, en_inventario=%s, envios_a=%s, tamanio_o_talla=%s, colores_disponibles=%s, personalizacion=%s, contacto=%s WHERE id=%s",
                       GetSQLValueString($_POST['producto'], "text"),
                       GetSQLValueString($_POST['disponibles'], "text"),
                       GetSQLValueString($_POST['precio'], "text"),
                       GetSQLValueString($_POST['en_inventario'], "text"),
                       GetSQLValueString($_POST['envios_a'], "text"),
                       GetSQLValueString($_POST['tamanio_o_talla'], "text"),
                       GetSQLValueString($_POST['colores_disponibles'], "text"),
                       GetSQLValueString($_POST['personalizacion'], "text"),
                       GetSQLValueString($_POST['contacto'], "text"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_CR7, $CR7);
  $Result1 = mysql_query($updateSQL, $CR7) or die(mysql_error());

  $updateGoTo = "lista.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$maxRows_modificar = 1;
$pageNum_modificar = 0;
if (isset($_GET['pageNum_modificar'])) {
  $pageNum_modificar = $_GET['pageNum_modificar'];
}
$startRow_modificar = $pageNum_modificar * $maxRows_modificar;

mysql_select_db($database_CR7, $CR7);
$query_modificar = "SELECT * FROM cr7";
$query_limit_modificar = sprintf("%s LIMIT %d, %d", $query_modificar, $startRow_modificar, $maxRows_modificar);
$modificar = mysql_query($query_limit_modificar, $CR7) or die(mysql_error());
$row_modificar = mysql_fetch_assoc($modificar);

if (isset($_GET['totalRows_modificar'])) {
  $totalRows_modificar = $_GET['totalRows_modificar'];
} else {
  $all_modificar = mysql_query($query_modificar);
  $totalRows_modificar = mysql_num_rows($all_modificar);
}
$totalPages_modificar = ceil($totalRows_modificar/$maxRows_modificar)-1;

$queryString_modificar = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_modificar") == false && 
        stristr($param, "totalRows_modificar") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_modificar = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_modificar = sprintf("&totalRows_modificar=%d%s", $totalRows_modificar, $queryString_modificar);
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
      <td><?php echo $row_modificar['id']; ?></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Producto:</td>
      <td><input type="text" name="producto" value="<?php echo $row_modificar['producto']; ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Disponibles:</td>
      <td><input type="text" name="disponibles" value="<?php echo $row_modificar['disponibles']; ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Precio:</td>
      <td><input type="text" name="precio" value="<?php echo $row_modificar['precio']; ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">En_inventario:</td>
      <td><input type="text" name="en_inventario" value="<?php echo $row_modificar['en_inventario']; ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Envios_a:</td>
      <td><input type="text" name="envios_a" value="<?php echo $row_modificar['envios_a']; ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Tamanio_o_talla:</td>
      <td><input type="text" name="tamanio_o_talla" value="<?php echo $row_modificar['tamanio_o_talla']; ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Colores_disponibles:</td>
      <td><input type="text" name="colores_disponibles" value="<?php echo $row_modificar['colores_disponibles']; ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Personalizacion:</td>
      <td><input type="text" name="personalizacion" value="<?php echo $row_modificar['personalizacion']; ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Contacto:</td>
      <td><input type="text" name="contacto" value="<?php echo $row_modificar['contacto']; ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><input type="submit" value="Actualizar registro"></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1">
  <input type="hidden" name="id" value="<?php echo $row_modificar['id']; ?>">
</form>
<table border="0" width="50%" align="center">
  <tr>
    <td width="23%" align="center"><?php if ($pageNum_modificar > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_modificar=%d%s", $currentPage, 0, $queryString_modificar); ?>">Primero</a>
          <?php } // Show if not first page ?>
    </td>
    <td width="31%" align="center"><?php if ($pageNum_modificar > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_modificar=%d%s", $currentPage, max(0, $pageNum_modificar - 1), $queryString_modificar); ?>">Anterior</a>
          <?php } // Show if not first page ?>
    </td>
    <td width="23%" align="center"><?php if ($pageNum_modificar < $totalPages_modificar) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_modificar=%d%s", $currentPage, min($totalPages_modificar, $pageNum_modificar + 1), $queryString_modificar); ?>">Siguiente</a>
          <?php } // Show if not last page ?>
    </td>
    <td width="23%" align="center"><?php if ($pageNum_modificar < $totalPages_modificar) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_modificar=%d%s", $currentPage, $totalPages_modificar, $queryString_modificar); ?>">&Uacute;ltimo</a>
          <?php } // Show if not last page ?>
    </td>
  </tr>
</table>
</p>
</body>
</html>
<?php
mysql_free_result($modificar);
?>
