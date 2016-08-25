
var thumbnailSpacing =15;
var userdir;
var user;
var result;
$(document).ready(function()
{
		user= $("#user").text();
		$('a.sortLink').on('click', 
		function(e)
		{	   
				   e.preventDefault();
				   $(".thumbnail").remove();
				   $('a.sortLink').removeClass('selected');
				   $(this).addClass('selected');
				   var keyword = $(this).attr('data-keyword');

				   $.post("helper2.php",{post_id:user,post_key:keyword},
				   function(data)
				   {
						   result = data;
						   alert(result);
						   for (var a = 1; a <= result; a++) 
						   {
									var mydiv = document.getElementById("myDiv");
									var aTag = document.createElement('a');
									aTag.setAttribute('href',"#");
									aTag.setAttribute("class", "thumbnail");
									aTag.setAttribute("data-keywords", "temp");
									mydiv.appendChild(aTag);
						   }
						   sortThumbnails(keyword);
				  });

		});
		$('gallery .sorting .container').css('margin-bottom',window.thumbnailSpacing+ 'px');
		$('.thumbnail_container a.thumbnail').addClass('showMe');
		positionThumbnails();
});

function sortThumbnails(keyword)
{
		$('.thumbnail_container a.thumbnail').each(function(i)
		{
					$(this).addClass('showMe').removeClass('hideMe');
					userdir = "./users/"+user+"/gallery/"+keyword;
					$(this).empty().prepend("<img src = '"+ userdir +"/"+(++i)+".jpg' width='79'' height ='79' />");  
		});
		positionThumbnails();
}



function positionThumbnails()
{
		 $('.thumbnail_container a.thumbnail.hideMe').animate({opacity:0}, 500,function()		  {
			 $(this).css({'display':'none', 'top':'0px', 'left':'0px'});
		 });

		 var containerWidth =
		 $('.photos').width();
		 var thumbnail_R =0;
		 var thumbnail_C =0;
		 var thumbnailWidth = $('a.thumbnail img:first-child').outerWidth() +         window.thumbnailSpacing;
		 var thumbnailHeight = $('a.thumbnail img:first-child').outerHeight() +          window.thumbnailSpacing;
		 var max_C = Math.floor(containerWidth/thumbnailWidth);
         $('.thumbnail_container a.thumbnail.showMe').each(function(index)
         {
					 var remainder = (index%max_C)/100;
					 var maxIndex =0;
					 if(remainder == 0)
					 {
							 if(index != 0)
							 {
									thumbnail_R += thumbnailHeight;
							 }
							 thumbnail_C =0; 

					 }
					 else
					 {
							thumbnail_C += thumbnailWidth;
					 }

					 $(this).css('display', 'block').animate(
					 {
							'opacity':1, 'top':thumbnail_R +'px','left':thumbnail_C+'px'
					 }, 500);

					 var newWidth = max_C * thumbnailWidth;
					 var newHeight = thumbnail_R + thumbnailHeight;
					 $('.thumbnail_container').css({'width':newWidth+'px','height':newHeight+'px'});

	    });
}
		  
		

                                        
