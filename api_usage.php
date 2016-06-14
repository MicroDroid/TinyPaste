<!DOCTYPE html>
<html>
<head>
	<title>TinyPaste - API</title>
	<?php require_once("res/components/default_header.php"); ?>
	<style>
		body {
			padding-top: 96px;
			padding-right: 16px;
			padding-left: 16px;
		}

		footer {
			margin-top: 48px;
			text-align: center;
		}

		tr {
			border-bottom: 1px solid rgba(255, 255, 255, 0.5);
		}

		thead {
			border-bottom: 2px solid rgba(255, 255, 255, 0.6);
		}
	</style>
</head>
<body>
<?php require_once("res/components/navbar.php"); ?>

<h2>Our simple quota-less API</h2>
<p>It's pretty easy to use, you just <code>POST</code> to <code>/api/v1/paste.php</code> with <code>code</code> parameter containing the data to be pasted, the response is a <code>JSON</code> with the following fields:</p>
<br>
<div class="table-responsive">
	<table class="table">
		<thead>
			<tr>
				<td>Field</td>
				<td>Description</td>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>status</td>
				<td>An HTTP code, 200 when everything goes fine</td>
			</tr>
			<tr>
				<td>error</td>
				<td>Human readable error, if status is 200, it's empty</td>
			</tr>
			<tr>
				<td>rich_link</td>
				<td>Only exists if status is 200, contains link with code highlighting</td>
			</tr>
			<tr>
				<td>raw_link</td>
				<td>Only exists if status is 200, contains raw link without any markup</td>
			</tr>
		</tbody>
	</table>
</div>

</body>
</html>