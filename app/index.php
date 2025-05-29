<?php
	session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Survey Form</title>
	<link rel="stylesheet" href="style/output.css">
</head>

<body class="bg-light flex flex-col items-center justify-center py-10">
	<div class="flex flex-col flex-auto gap-y-4">
		<?php include 'script/survey_form.php'; ?>
		<div class="flex-auto justify-center items-center flex-row px-4 py-2 w-100">
			<a href="script/survey_results.php" class="flex justify-self-center flex-auto rounded-xl bg-accent text-white px-4 py-2 text-center hover:bg-opacity-90 transition-colors">
				See results
			</a>
		</div>
	</div>
</body>
	
</html>