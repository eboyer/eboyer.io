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
<div class="Site">
  <a class="Logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
  <?php wp_nav_menu( array( 'theme_location' => 'primary', 'container' => false ) ); ?>

