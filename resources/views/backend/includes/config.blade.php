<script>
<?php $settings_user =  access()->user()->settings;?>
var config = {
	@foreach($settings_user as $set)
	'{{$set->model}}_{{$set->name}}' : '{{$set->param}}',
	@endforeach
};
</script>