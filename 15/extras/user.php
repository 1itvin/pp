<?php
class User
{
  private $name;
  private $login;
  private $pass;
  private $file;
  private $email;
  private $country;

  function __construct($name, $login, $pass, $file, $email, $country)
  {
    $this->name = $name;
    $this->login = $login;
    $this->pass = $pass;
    $this->file = $file;
    $this->email = $email;
    $this->country = $country;
  }

  function get_name()
  {
    return $this->name;
  }
  function get_login()
  {
    return $this->login;
  }
  function get_pass()
  {
    return $this->pass;
  }
  function get_file()
  {
    return $this->file;
  }
  function get_email()
  {
    return $this->email;
  }
  function get_country()
  {
    return $this->country;
  }

  function set_name($new_name)
  {
    $this->name = $new_name;
  }
  function set_login($new_login)
  {
    $this->login = $new_login;
  }
  function set_pass($new_pass)
  {
    $this->pass = $new_pass;
  }
  function set_file($new_file)
  {
    $this->file = $new_file;
  }
  function set_email($new_email)
  {
    $this->email = $new_email;
  }
  function set_country($new_country)
  {
    $this->country = $new_country;
  }
}
