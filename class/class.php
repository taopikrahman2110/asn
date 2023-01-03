<?php

session_start();

require_once'class_db.php';

date_default_timezone_set("Asia/Jakarta");

class System
{
	public $base_url = "http://localhost/asn/"; // ke ubah kadie 

	public function __construct() 
	{
		$this->db = new Db();
	}

	public function base_url($url = '')
	{
		return $funcbaseurl = $this->base_url.$url;
	}

	public function alihkan($url = '')
	{
		$baseurl = $this->base_url.$url;
		echo '<script>window.location.href="' . $baseurl . '";</script>';
		exit();
	}

	public function alihkandelay($url = '', $delay)
	{
		$baseurl = $this->base_url.$url;
		echo '<script>setTimeout(function () {
			window.location.href = "' . $baseurl . '";
		}, "' . $delay . '");</script>';
		exit();
	}

	public function IsLogged() // mendeteksei sudah status login atau acan
	{
		if(isset($_SESSION['logged']))
		{
			if($_SESSION['logged'] == true)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
		return false;
	}


	public function Login($username, $password) // fungsi login
	{
		$username = $this->db->AI($username);
		$password = $this->db->AI($password);
		$hashpw   = hash('sha1', $password);

		if($this->db->tersedia("admin", "username", $username))
		{
			$hasil = $this->db->select("SELECT * FROM `admin` WHERE `username` = '$username'");

			if($hasil[0]['password'] == $hashpw)
			{
				$_SESSION['logged'] = true;
				$_SESSION['username'] = $username;
				$_SESSION['idadmin'] = $hasil[0]['idadmin'];
				$_SESSION['nama'] = $hasil[0]['namalengkap'];
				$this->alihkan('admin');
			}
			else
			{
				echo '<script type="text/javascript">Swal.fire("Error !","Login gagal! username tidak terdaftar atau password salah!","error")</script>';
			}
		}elseif ($this->db->tersedia("apotek", "username", $username)) {
			$hasil = $this->db->select("SELECT * FROM `apotek` WHERE `username` = '$username'");

			if($hasil[0]['password'] == $hashpw)
			{
				$_SESSION['logged'] = true;
				$_SESSION['username'] = $username;
				$_SESSION['idapotek'] = $hasil[0]['idapotek'];
				$_SESSION['nama'] = $hasil[0]['nama_apoteker'];
				$this->alihkan('homeAP');
			}
			else
			{
				echo '<script type="text/javascript">Swal.fire("Error !","Login gagal! username tidak terdaftar atau password salah!","error")</script>';
			}
		}elseif ($this->db->tersedia("perawat", "username", $username)) {
			$hasil = $this->db->select("SELECT * FROM `perawat` WHERE `username` = '$username'");

			if($hasil[0]['password'] == $hashpw)
			{
				$_SESSION['logged'] = true;
				$_SESSION['username'] = $username;
				$_SESSION['id'] = $hasil[0]['id'];
				$_SESSION['nama'] = $hasil[0]['nama_perawat'];
				$this->alihkan('homePR');
			}
			else
			{
				echo '<script type="text/javascript">Swal.fire("Error !","Login gagal! username tidak terdaftar atau password salah!","error")</script>';
			}
		}elseif ($this->db->tersedia("pasien", "username", $username)) {
			$hasil = $this->db->select("SELECT * FROM `pasien` WHERE `username` = '$username'");

			if($hasil[0]['password'] == $hashpw)
			{
				$_SESSION['logged'] = true;
				$_SESSION['username'] = $username;
				$_SESSION['id'] = $hasil[0]['id'];
				$_SESSION['nama'] = $hasil[0]['nama'];
				$this->alihkan('homePS');
			}
			else
			{
				echo '<script type="text/javascript">Swal.fire("Error !","Login gagal! username tidak terdaftar atau password salah!","error")</script>';
			}
		}
		else
		{
			echo '<script type="text/javascript">Swal.fire("Error !","Login gagal! username tidak terdaftar atau password salah!","error")</script>';
			return true;
		}
		return false;
	}

}

?>