<?php
/*
	(c) Copyright Zhiemy.com 2016
	Silahkan di edit-edit, CMS ini dibuat untuk teman-teman yang pengen belajar bikin website
	FREE OPENSOURCE!!!
*/

class Fungsidata extends Dbs
{

   public function select($table, $select = '*', $where)
   {

      if (!empty($where)) {
         if (substr(strtoupper(trim($where)), 0, 5) != 'WHERE') {
            $where = " WHERE " . $where;
         } else {
            $where = " " . trim($where);
         }
      }

      $sql = "SELECT " . $select . " FROM " . $table . " ";
      $sql .= $where;

      $result = $this->konek()->query($sql);
      return $result;
   }

   public function insert($table, $field)
   {
      $columns = implode(", ", array_keys($field));
      $values  = "'" . implode("', '", $field) . "'";

      $sql = "INSERT into " . $table . " (" . $columns . ") values (" . $values . ")";
      $result = $this->konek()->query($sql);

      return $result;
   }

   public function update($table, $field, $where)
   {
      if (!empty($where)) {
         if (substr(strtoupper(trim($where)), 0, 5) != 'WHERE') {
            $where_sql = " WHERE " . $where;
         } else {
            $where_sql = " " . trim($where);
         }
      }

      $sql = "UPDATE " . $table . " SET ";
      $sets = array();
      foreach ($field as $column => $value) {
         $sets[] = "`" . $column . "` = '" . $value . "'";
      }
      $sql .= implode(', ', $sets);
      $sql .= $where_sql;

      $result = $this->konek()->query($sql);

      return $result;
   }

   public function delete($table, $where = '')
   {
      if (!empty($where)) {
         if (substr(strtoupper(trim($where)), 0, 5) != 'WHERE') {
            $where_sql = " WHERE " . $where;
         } else {
            $where_sql = " " . trim($where);
         }
      }
      $sql = "DELETE FROM " . $table . $where_sql;

      $result = $this->konek()->query($sql);

      return $result;
   }
   public function login()
   {
      $username = $_POST['username'];
      $password = $_POST['password'];

      $sql = "SELECT * from user where username = '$username'";
      $result = $this->konek()->query($sql);
      $numrows = $result->num_rows;
      $data = $result->fetch_assoc();

      if ($numrows > 0) {

         if (password_verify($password, $data['password'])) {

            session_start();
            $_SESSION['username'] = $data['username'];
            $_SESSION['level'] = $data['level'];
            $_SESSION['nama'] = $data['nama_user'];

            return TRUE;
         } else {
            return FALSE;
         }
      } else {
         return FALSE;
      }
   }
}
