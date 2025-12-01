<?php

class Connection{
	public function connect(){
		$link = new PDO("mysql:host=localhost;dbname=emb_appform2", "django_user", "djangodbpass");

		$link -> exec("set names utf8");
		return $link;
	}
}