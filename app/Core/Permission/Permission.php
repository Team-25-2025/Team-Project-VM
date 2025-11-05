<?php
namespace App\Core\Permission;

class Permission {
  public const Map = [
    "employee" => Employee::class,
    "manager" => Manager::class,
    "teamleader" => TeamLeader::class
  ];
  public static function resolve(array $keys) {
    if (!$keys) return;

    foreach ((array) $keys as $key) {
      $permission = Permission::Map[$key] ?? null;

      if (!$permission) {
          throw new \Exception("No matching permission found for key '{$key}'.");
      }

      (new $permission)->handle($keys);
    }
  }
}