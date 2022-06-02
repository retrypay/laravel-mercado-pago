<?php
namespace OscarRey\MercadoPago\Entity;

use MercadoPago\POS as MercadoPagoPOS;
use OscarRey\MercadoPago\Traits\EntityTrait;
use OscarRey\MercadoPago\Interfaces\ClassToJson;


class POS extends MercadoPagoPOS implements ClassToJson
{
   use EntityTrait;
  
}