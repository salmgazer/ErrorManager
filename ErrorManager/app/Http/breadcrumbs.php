<?php

//Home
Breadcrumbs::register('home', function($breadcrumbs){
  $breadcrumbs->push('Home', route('home'));
});

//Resubmit bulk in progress by oc_name
Breadcrumbs::register('Bulk Resubmit', function($breadcrumbs){
  $breadcrumbs->push('Home', route('Bulk Resubmit'));
});

//In  progress bulk oc_name
Breadcrumbs::register('Bulk In Progress (oc_name)', function($breadcrumbs){
  $breadcrumbs->parent('home');
  $breadcrumbs->push('Bulk In Progress (oc_name)', route('Bulk In Progress (oc_name)'));
});

//In progress bulk oc_id
Breadcrumbs::register('Bulk In Progress (oc_id)', function($breadcrumbs){
  $breadcrumbs->parent('home');
  $breadcrumbs->push('Bulk In Progress (oc_id)', route('Bulk In Progress (oc_id)'));
});

//Single errors
Breadcrumbs::register('Single Errors', function($breadcrumbs){
  $breadcrumbs->parent('home');
  $breadcrumbs->push('Single Errors', route('Single Errors'));
});

//Sigle Errors - History
Breadcrumbs::register('Single Errors - History', function($breadcrumbs){
  $breadcrumbs->parent('home');
  $breadcrumbs->push('Single Errors - History', route('Single Errors - History'));
});

//Bulk Errors History
Breadcrumbs::register('Bulk Errors - History', function($breadcrumbs){
  $breadcrumbs->parent('home');
  $breadcrumbs->push('Bulk Errors - History', route('Bulk Errors - History'));
});

//Profile view
Breadcrumbs::register('Profile', function($breadcrumbs){
  $breadcrumbs->parent('home');
  $breadcrumbs->push('Profile', route('Profile'));
});

//list users - superadmin
Breadcrumbs::register('users', function($breadcrumbs){
  $breadcrumbs->push('Home', route('users'));
});

//add new user
Breadcrumbs::register('Add user', function($breadcrumbs){
  $breadcrumbs->parent('users');
  $breadcrumbs->push('Add user', route('Add user'));
});
 ?>
