<?php
class Webservices_model extends CI_Model
{

function article_list(){
	$articles=$this->db->query('select * from ag_article_list where status="1" and language_id="2" order by id desc')->result_array();
	return $articles;
}

public function article_banner_list(){
	$article_banners=$this->db->query('select id,image_path from ag_article_list where status="1" and language_id="2" and banner_status="yes" order by id desc limit 4')->result_array();
	return $article_banners;
}

public function article_get_id($article_id){
 $query='select * from ag_article_list where id="'.$article_id.'"';
   $article=$this->db->query($query)->row_array();
	return $article;
}

public function get_editorial($year,$month){
   $query='select * from ag_editorial where year_id="'.$year.'" and month_id="'.$month.'" and status="Active" and delete_status="1"  and language_id="2" ';
  // echo $query;exit;
   $editorial=$this->db->query($query)->row_array();
	return $editorial;
}

}

?>