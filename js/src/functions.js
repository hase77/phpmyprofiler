function expandBoxset(theitems, theimg, theme)
{
    var item = document.getElementById(theitems);
    var img = document.getElementById(theimg);

    if (item.style.display == 'none') {
	item.style.display = '';
	img.src = 'themes/'+theme+'/images/minus.gif';
    }
    else {
	item.style.display = 'none';
	img.src = 'themes/'+theme+'/images/plus.gif';
    }
}

function popUpWindow(url, name, width, height, scroll)
{
    var LeftPosition = (screen.width) ? (screen.width-width)/2 : 0;
    var TopPosition = (screen.height) ? (screen.height-height)/2 : 0;
    var settings = 'height='+height+',width='+width+',top='+TopPosition+',left='+LeftPosition+',scrollbars='+scroll+',resizable';
    window = window.open(url, name, settings);
}

function insertSmiley(smiley)
{
    document.getElementById('guestbook').message.value+=smiley+" ";
    document.getElementById('guestbook').message.focus();
}
