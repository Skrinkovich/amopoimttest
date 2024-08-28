
let selement = document.getElementsByName('type_val')[0];
selement.addEventListener('change', function(ev) {
	
	let pElementsNodeList = Array.from(document.querySelectorAll('p'));  
	let selectedValue = Array.from(document.querySelectorAll('select'))[0].value;
	
	pElementsNodeList.splice(0, 1); 
	pElementsNodeList.forEach(p => {  
	
	let hide = false; 
	try{
		if (p.textContent.indexOf(selectedValue) !== -1) {hide = true;} // подходящее поле
		if (p.firstChild.value.includes(selectedValue)  === true) {hide = true;} // подходящая кнопка
	}
	catch(error) {}
	if ( hide == false  )//
	{	
		p.hidden = true; 
	}
	else
	{
		p.hidden = false;
	}
		
	}); 
	 
	
}); 