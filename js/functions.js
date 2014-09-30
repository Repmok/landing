
function CheckMessage(action)
{
	switch (action) {
		case 'exist':
			jQuery("#message")[0].textContent = "Email Already Exists";
			break;

		case 'saved':
			jQuery("#message")[0].textContent = "Information Saved Successfully";
			break;

		case 'fill':
			jQuery("#message")[0].textContent = "Please Fill The Information";
			break;
		case 'email':
			jQuery("#formContainer").hide();
			jQuery("#registerMsg").show();
			break;
	}
}

function Translation(Lang)
{
	var Language;
	//Hide FinalMsg Container
	jQuery("#registerMsg").hide();
	
	//Remove Selected Class
	jQuery("#langSection li.selected").removeClass("selected");

	if(Lang === null)
	{ Language = "english"; }
	else
	{
		if(Lang != null && Lang === "es")
		{ Language = "spanish";}
		else
		{ Language = "english";}
	}

	AddScript(Language);

	//Add Selected Class
	jQuery("#"+ Language + "").addClass("selected");
	jQuery("#Language")[0].value = Language;

	jQuery.ajax({
        url: 'translations.xml',
        success: function(xml) {
            jQuery(xml).find('translation').each(function(){
                var id = jQuery(this).attr('id');
                var text = jQuery(this).find(Language).text();

                switch (id) {
				    case "submit":
				        jQuery("." + id).attr("value",text); 
				    	break;
				    case "email":
				    case "name":
				    case "lastname":
				    	jQuery("." + id).attr("placeholder",text); 
				        break;
				    default:
				    	jQuery("." + id).html(text);
				    	break;
				}
            });
        }
    });
}

function AddScript(param)
{
	var head = document.getElementsByTagName('head')[0];
	var script = document.createElement('script');		
	script.type = 'text/javascript';

	if(param === "spanish")
	{
		 script.src = 'js/messages_es.js'; 
	}
	else
	{ 
		script.src = 'js/messages_en.js';
	}

	head.appendChild(script);
}