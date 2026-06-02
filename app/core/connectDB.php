<?php
 class connectDB
 {
     private static $host = "127.0.0.1";
     private static $port = "3307";
     private static $username = "root";
     private static $password = "";
     private static $dbname = "tranvantung_0028268_68pm3";
     private static $conn;

     public static function Connect()
     {
         // Tạo kết nối
         if (!self::$conn) {
            try {
               self::$conn = new PDO("mysql:host=" . self::$host . ";port=" . self::$port . ";dbname=" . self::$dbname, self::$username, self::$password);
               self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
            catch (PDOException $e) {
               return null;
            }
         }
         return self::$conn;
     }

     public function __destruct()
     {
         // Đóng kết nối khi đối tượng bị hủy
         if (self::$conn) {
             self::$conn = null;
         }
     }
 }
