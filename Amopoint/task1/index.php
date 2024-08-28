<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Задание 1</title> 
	<link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Задание 1</h2>
    <form id="uploadForm" enctype="multipart/form-data">
		<input type="text" id="delimeter" name="delimeter"> разделитель<p></p>
        <input type="file" id="fileInput" name="file">
        <button type="submit">Загрузить</button>
    </form>

    <div id="progressBar"><div></div></div>
    <p id="status"></p>
	<div id="responsePlace"></div>

    <script src="javascript.js"></script>

</body>
</html>
