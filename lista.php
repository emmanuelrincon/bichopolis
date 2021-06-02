<?php require_once('Connections/CR7.php'); ?>
<?php
$currentPage = $_SERVER["PHP_SELF"];

$maxRows_lista = 2;
$pageNum_lista = 0;
if (isset($_GET['pageNum_lista'])) {
  $pageNum_lista = $_GET['pageNum_lista'];
}
$startRow_lista = $pageNum_lista * $maxRows_lista;

mysql_select_db($database_CR7, $CR7);
$query_lista = "SELECT * FROM cr7";
$query_limit_lista = sprintf("%s LIMIT %d, %d", $query_lista, $startRow_lista, $maxRows_lista);
$lista = mysql_query($query_limit_lista, $CR7) or die(mysql_error());
$row_lista = mysql_fetch_assoc($lista);

if (isset($_GET['totalRows_lista'])) {
  $totalRows_lista = $_GET['totalRows_lista'];
} else {
  $all_lista = mysql_query($query_lista);
  $totalRows_lista = mysql_num_rows($all_lista);
}
$totalPages_lista = ceil($totalRows_lista/$maxRows_lista)-1;

$queryString_lista = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_lista") == false && 
        stristr($param, "totalRows_lista") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_lista = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_lista = sprintf("&totalRows_lista=%d%s", $totalRows_lista, $queryString_lista);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>lista</title>
</head>

<body>
<table border="1">
  <tr>
    <td>id</td>
    <td>producto</td>
    <td>disponibles</td>
    <td>precio</td>
    <td>en_inventario</td>
    <td>envios_a</td>
    <td>tamanio_o_talla</td>
    <td>colores_disponibles</td>
    <td>personalizacion</td>
    <td>contacto</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><a href="eliminar.php?id=<?php echo $row_lista['id']; ?>"><?php echo $row_lista['id']; ?></a></td>
      <td><?php echo $row_lista['producto']; ?></td>
      <td><?php echo $row_lista['disponibles']; ?></td>
      <td><?php echo $row_lista['precio']; ?></td>
      <td><?php echo $row_lista['en_inventario']; ?></td>
      <td><?php echo $row_lista['envios_a']; ?></td>
      <td><?php echo $row_lista['tamanio_o_talla']; ?></td>
      <td><?php echo $row_lista['colores_disponibles']; ?></td>
      <td><?php echo $row_lista['personalizacion']; ?></td>
      <td><?php echo $row_lista['contacto']; ?></td>
    </tr>
    <?php } while ($row_lista = mysql_fetch_assoc($lista)); ?>
</table>
<p>
<table border="0" width="50%" align="center">
  <tr>
    <td width="23%" align="center"><?php if ($pageNum_lista > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_lista=%d%s", $currentPage, 0, $queryString_lista); ?>">Primero</a>
          <?php } // Show if not first page ?>
    </td>
    <td width="31%" align="center"><?php if ($pageNum_lista > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_lista=%d%s", $currentPage, max(0, $pageNum_lista - 1), $queryString_lista); ?>">Anterior</a>
          <?php } // Show if not first page ?>
    </td>
    <td width="23%" align="center"><?php if ($pageNum_lista < $totalPages_lista) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_lista=%d%s", $currentPage, min($totalPages_lista, $pageNum_lista + 1), $queryString_lista); ?>">Siguiente</a>
          <?php } // Show if not last page ?>
    </td>
    <td width="23%" align="center"><?php if ($pageNum_lista < $totalPages_lista) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_lista=%d%s", $currentPage, $totalPages_lista, $queryString_lista); ?>">&Uacute;ltimo</a>
          <?php } // Show if not last page ?>
    </td>
  </tr>
</table>
</p>
</body>
</html>
<?php
mysql_free_result($lista);
?>
