<?php
  $rol = session('user')->rol;
  if ($rol == 'admin') {
    include('sidebar-admin.php');
  } elseif ($rol == 'user') {
    include('sidebar-user.php');
  } elseif ($rol == 'operator') {
    include('sidebar-operator.php');
  }
?>