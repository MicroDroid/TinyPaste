<!DOCTYPE html>
<html>
<head>
	<title>TinyPaste</title>
	<?php require_once("res/components/default_header.php"); ?>
	<style>
		body {
			text-align: center;
			padding-top: 96px;
		}

		#code {
			width: 90%;
			min-height: 380px;
			margin-right: auto;
			margin-left: auto;
			resize: vertical;
			font-family: Consolas;
		}

		#paste-btn {
			margin-top: 28px;
		}

		#loading, #status, #results {
			margin-top: 36px;
		}

		#status {
			margin-right: auto;
			margin-left: auto;
			width: 50%;
		}

		#results {
			display: block;
			position: relative;
			left: 50%;
			transform: translateX(-50%);
		}

		.hidden {
			display: none;
		}

		.spinner {
			margin: 100px auto 0;
			width: 70px;
			text-align: center;
		}

		.spinner > div {
			width: 18px;
			height: 18px;
			background-color: #333;

			border-radius: 100%;
			display: inline-block;
			-webkit-animation: sk-bouncedelay 1.4s infinite ease-in-out both;
			animation: sk-bouncedelay 1.4s infinite ease-in-out both;
		}

		.spinner .bounce1 {
			-webkit-animation-delay: -0.32s;
			animation-delay: -0.32s;
		}

		.spinner .bounce2 {
			-webkit-animation-delay: -0.16s;
			animation-delay: -0.16s;
		}

		@-webkit-keyframes sk-bouncedelay {
			0%, 80%, 100% { -webkit-transform: scale(0) }
			40% { -webkit-transform: scale(1.0) }
		}

		@keyframes sk-bouncedelay {
			0%, 80%, 100% { 
				-webkit-transform: scale(0);
				transform: scale(0);
			} 40% { 
				-webkit-transform: scale(1.0);
				transform: scale(1.0);
			}
		}
	</style>
	<script type="text/javascript">
		var code;
		var paste_btn;
		var loading;
		var rich_link;
		var raw_link;
		var paste_status;

		$(function() {
			code = $("#code");
			paste_btn = $("#paste-btn");
			loading = $("#loading");
			rich_link = $("#rich-link");
			raw_link = $("#raw-link");
			results = $("#results");
			paste_status = $("#status");

			$('textarea').on('keydown', function(ev) {
		    var keyCode = ev.keyCode || ev.which;
			    if (keyCode == 9) {
			        ev.preventDefault();
			        var start = this.selectionStart;
			        var end = this.selectionEnd;
			        var val = this.value;
			        var selected = val.substring(start, end);
			        var re, count;

			        if(ev.shiftKey) {
			            re = /^\t/gm;
			            count = -selected.match(re).length;
			            this.value = val.substring(0, start) + selected.replace(re, '') + val.substring(end);
			            // todo: add support for shift-tabbing without a selection
			        } else {
			            re = /^/gm;
			            count = selected.match(re).length;
			            this.value = val.substring(0, start) + selected.replace(re, '\t') + val.substring(end);
			        }

			        if(start === end) {
			            this.selectionStart = end + count;
			        } else {
			            this.selectionStart = start;
			        }

			        this.selectionEnd = end + count;
			    }
			});
		});

		function paste() {
			if (code.val() === "")
				return;
			paste_btn.attr("disabled", true);
			paste_status.addClass("hidden");
			loading.removeClass("hidden");
			results.addClass("hidden");
			$.ajax({
				url: "api/v1/paste.php",
				type: "POST",
				data: {code: code.val()},
				success: function(result, status, xhr) {
					paste_btn.attr("disabled", false);
					loading.addClass("hidden");
					var json = jQuery.parseJSON(result);
					if (json["status"] != 200) {
						paste_status.text("Error! " + json["error"]);
						paste_status.removeClass("hidden");
					} else {
						rich_link.val(json["rich_link"]);
						raw_link.val(json["raw_link"]);
						results.removeClass("hidden");
					}
				},
				error: function(xhr, status, error) {
					paste_btn.attr("disabled", false);
					loading.addClass("hidden");
					paste_status.text("Can't connect to server");
					paste_status.removeClass("hidden");
				}
			});
		}
	</script>
</head>
<body>
<?php require_once("res/components/navbar.php"); ?>

<textarea class="form-control" id="code" placeholder="Code here" autofocus></textarea>
<button class="btn btn-primary" id="paste-btn" onclick="paste()">Paste</button>

<div class="hidden" id="loading">
  <div class="bounce1"></div>
  <div class="bounce2"></div>
  <div class="bounce3"></div>
</div>

<div class="alert alert-danger hidden" role="alert" id="status"></div>

<div class="col-lg-6 hidden" id="results">
	<div class="input-group">
		<span class="input-group-btn">
			<button class="btn btn-default" type="button">Link</button>
		</span>
		<input type="text" class="form-control" id="rich-link" onclick="this.select()" readonly>
	</div>
	<br>
	<div class="input-group">
		<span class="input-group-btn">
			<button class="btn btn-default" type="button">Raw</button>
		</span>
		<input type="text" class="form-control" id="raw-link" onclick="this.select()" readonly>
	</div>
</div>

</body>
</html>