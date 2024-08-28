document.getElementById('uploadForm').addEventListener('submit', function(event) {
    event.preventDefault();
	let delimeterInput = document.getElementById('delimeter').value;
    let fileInput = document.getElementById('fileInput');
	let responsePlace = document.getElementById('responsePlace');
    let file = fileInput.files[0];

    if (file) {
        let formData = new FormData();
		
        formData.append('delimeter', delimeterInput);
        formData.append('file', file);
		
        let xhr = new XMLHttpRequest();
		
        xhr.upload.addEventListener('progress', function(e) {
            if (e.lengthComputable) {
                let percentComplete = Math.round((e.loaded / e.total) * 100);
                document.querySelector('#progressBar div').style.width = percentComplete + '%';
                document.getElementById('status').textContent = "загружено "+percentComplete + '%';
            }
        }); 
		
        xhr.addEventListener('load', function() {
            document.getElementById('status').textContent = 'загружено';
        });
		
        xhr.addEventListener('error', function() {
            document.getElementById('status').textContent = 'при загрузке произошла ошибка ';
			responsePlace.innerHTML = 'ошибка: ' + xhr.status;
			document.querySelector('#progressBar div').style.background = "#e64017"; 
        });
		
        xhr.open('POST', 'backend.php', true); 
		
		xhr.onload = function () {
			if (xhr.status === 200) {  
				if (JSON.parse(xhr.responseText)["error"])
				{
					responsePlace.innerHTML =  JSON.parse(xhr.responseText)["error"];  
					document.querySelector('#progressBar div').style.background = "#e64017"; 
				}
				else 
				{	
					document.querySelector('#progressBar div').style.background = "#4caf50"; 
					let lines = JSON.parse(xhr.responseText)["result"];  
					let textToInsert = "";
					lines.forEach(line => { textToInsert+=line + "<br><br>";}); 
					responsePlace.innerHTML =  textToInsert; 
				}
			} else {
				responsePlace.innerHTML = 'ошибка: ' + xhr.status;
				document.querySelector('#progressBar div').style.background = "#e64017"; 
			}
		};
		
        xhr.send(formData);
    } else {
        alert('нужно выбрать файл');
    }
});
