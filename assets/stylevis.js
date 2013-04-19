function styleVisClicked(element, title_hide, desc_hide, title_show, desc_show)
{
	var idRegEx = /.*?id=(\d+).*/; 
	if (element.href.match(idRegEx))
	{
		var id = RegExp.$1;
		element.getLast('img').title = (element.getLast('img').src.indexOf('css_add') > 0) ? desc_hide : desc_show; 
		element.getLast('img').alt = (element.getLast('img').src.indexOf('css_add') > 0) ? title_hide : title_show; 
		element.getLast('img').src = (element.getLast('img').src.indexOf('css_add') > 0) ? element.getLast('img').src.replace(/css_add/, 'css_delete') : element.getLast('img').src.replace(/css_delete/, 'css_add'); 
		elem = document.getElementById('id'+id); 
		elem.getChildren('div').each(
			function(item,index)
			{ 
				strclass = item.getProperty('class'); 
				strstyle = item.getProperty('style'); 
				item.setProperty('style', strclass); 
				item.setProperty('class', strstyle); 
			}
		); 
		return false; 
	}
	return false;
}
