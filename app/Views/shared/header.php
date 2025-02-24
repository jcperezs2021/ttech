<!doctype html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <title>Trantor Technologies | <?= esc($title) ?></title>
  
  <link rel="shortcut icon" type="image/png" href="<?= base_url('assets/images/logos/logo-2.png') ?>" />
  <link rel="stylesheet" href="//cdn.datatables.net/2.1.7/css/dataTables.dataTables.min.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
  <link rel="stylesheet" href="<?= base_url('assets/css/styles.min.css') ?>" />
  <link rel="stylesheet" href="<?= base_url('assets/css/index.css') ?>" />

  <!-- jQuery -->
  <script src="<?= base_url('assets/libs/jquery/dist/jquery.min.js') ?>"></script>

<?php if ( strpos(uri_string(), 'documentos' ) !== false || strpos(uri_string(), 'documents' ) !== false ): ?>
  <!-- JsTree -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/jstree/dist/themes/default/style.min.css">  
  <script src="https://cdn.jsdelivr.net/npm/jstree/dist/jstree.min.js"></script>
<?php endif; ?>  

<?php if (strpos(uri_string(), 'organization') !== false): ?>
  <!-- OrgChart -->
  <script src="<?= base_url('assets/js/orgchart.js') ?>"></script>
<?php endif; ?>  

<?php if (strpos(uri_string(), 'user') !== false || strpos(uri_string(), 'documents') !== false || strpos(uri_string(), 'trantor-informa') !== false): ?>
  <!-- FilePond -->
  <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
  <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet" />
  <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
  <script src="https://unpkg.com/filepond/dist/filepond.js"></script>
<?php endif; ?>  

</head>

<!--  Body Wrapper -->
<div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
 