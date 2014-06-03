<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="shortify/assets/shortify.css">
  <!--[if lt IE 9]>
    <script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]--> 
  <title>Shortify</title>
</head>
<body>
  <div class="guns-dont-kill-people"><!-- wrappers do -->
    <header class="header">
      <nav class="navigation">
<?php if(Session::isLoggedIn()): ?>
        <ul class="navigation__inner">
          <li><strong>Shortify</strong></li>
          <li><a href="/add">Shorten URL</a></li>
          <li><a href="/upload">Upload File</a></li>
          <li><a href="/list">List All</a></li>
        </ul>
        <ul class="navigation__outer">
          <li><a href="/login">Log Out</a></li>
        </ul>
<?php else: ?>
        <ul class="navigation__inner">
          <li><strong>Shortify</strong></li>
        </ul>
        <ul class="navigation__outer">
          <li><a href="/login">Log In</a></li>
        </ul>
<?php endif; ?>
      </nav>
    </header>
    <main class="main">
