<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package eboyer
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" name="viewport">
  <link rel="profile" href="http://gmpg.org/xfn/11">

  <link rel="shortcut icon" href="<?php bloginfo('template_url'); ?>/favicon.ico">

  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <!--<?php wp_nav_menu( array( 'theme_location' => 'primary', 'container' => false ) ); ?>-->
  <div class="app">
    <div class="identity">
      <div class="avatar">
        <a class="Logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" title="<?php bloginfo( 'name' ); ?>">
          <img src="<?php bloginfo('template_url'); ?>/public/images/EricBoyer.jpg" alt="Eric Boyer">
        </a>
      </div>
      <h1>Eric Boyer</h1>
      <span class="title">Product Designer &amp; Developer</span>
      <div class="social">
        <ul>
          <li class="facebook">
            <a href="https://facebook.com/eboyer" title="Eric Boyer's Facebook" target="_blank">Eric Boyer's Facebook</a>
          </li>
          <li class="twitter">
            <a href="https://twitter.com/eboyer" title="Eric Boyer's Twitter" target="_blank">Eric Boyer's Twitter</a>
          </li>
          <li class="instagram">
            <a href="https://instagram.com/ejboyer" title="Eric Boyer's Instagram" target="_blank">Eric Boyer's Instagram</a>
          </li>
          <li class="github">
            <a href="https://github.com/eboyer" title="Eric Boyer's Github" target="_blank">Eric Boyer's Github</a>
          </li>
          <li class="linkedin">
            <a href="https://linkedin.com/in/ejboyer" title="Eric Boyer's LinkedIn" target="_blank">Eric Boyer's LinkedIn</a>
          </li>
        </ul>
      </div>
    </div>
    <div class="content">
