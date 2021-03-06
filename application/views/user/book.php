<?=render('includes.header'); ?>
<?=render('includes.navbar'); ?>
<div class="container">
<div class="content" id="content" style="display:none">
	<div class="page-header">
		<h2>Book Your Trips</h2>
	</div>
	<? foreach ($locations as $location): ?>
	<div class="row">
	<div class="span10 offset1">
		<form class="bookTrip">
		<table class="table table-bordered">
		<tbody>
		<tr class="info">
			<td colspan="3"><strong><?=$location->name; ?> Day <?=$location->day; ?></strong></td>
		</tr>
		</thead>
		<tbody>
		<? foreach ($trips[$location->name] as $trip): ?>
		<tr>
			<td><?=$trip->title; ?></td>
			<td><?=$trip->cost; ?>€</td>
			<td class="td-center"><input type="radio" name="tripID" value="<?=$trip->id ?>" required></td>
		</tr>
		<? endforeach; ?>
		</tbody>
		</table>
		<div class="pull-right">
			<button type="submit" class="btn btn-info btn-large">
			<i class="icon-ok icon-white"></i> Book it</button>
		</div>		
		<div class="alert alert-success" style="display: none; width:300px;">The trip has been booked!</div>
		<div class="alert alert-error" style="display: none; width:300px;">Error</div>
		</form>	
	</div>
	</div>
	<br>
	<? endforeach; ?>
</div>
<?=render('includes.footer'); ?>
</div>
<?=HTML::script('js/jquery.js'); ?>
<script>
$(document).ready(function() {

	$('.bookTrip').submit(function(){
		
		var form = $(this);
		var form_button = form.find('button');
		var alert_success = form.find('.alert.alert-success');
		var alert_error = form.find('.alert.alert-error');

		form_button.prop('disabled', true);
		alert_success.hide();
		alert_error.hide();
		
		var faction = "<?=URL::to('user/book_trip'); ?>";
		var fdata = form.serialize();

		$.post(faction, fdata, function(json) {
			
			if (json.success) {
				alert_success.show();
			} else {
				alert_error.html(json.message);
				alert_error.show();
			}

			form_button.prop('disabled', false);			
		});
			
		return false;
	});

	$('#nav-book').addClass('active');

	$('#content').fadeIn(1000);
});
</script>
</body>
</html>
