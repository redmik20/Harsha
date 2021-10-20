<ul id="subject-list">
	<?php
	if(!empty($venues))
	{
		foreach($venues as $row)
		{
			?>
			<li style="cursor: pointer;" ><a href="<?=base_url();?>home/venue_details/<?=$row->id;?>"><?=$row->venue_name;?></a></li>
			<?php
		}
	}
	else
	{
		?>
		<li>Search Not Found</li>
		<?php
	}
	?>
</ul>

<style type="text/css">
	a:hover
	{
		list-style:none;
		text-decoration: none;
	}
</style>