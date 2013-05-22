<?
class Collection_exercise extends DataMapper
{
	var $table = "collection_exercise";
	var $has_one = array('collection', 'exercise');
}
?>