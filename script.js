//This is where the JQuery function calls will happen

$( document ).ready(function() {
	//When any of our range inputs are changed
  $('input[type=range]').mouseup(function(){
	  
	  //This gets the index of the selected option from the dropdown list, 
	  //then selects the object from the list of options, and gets the value
	   var selectedShape=$("option").eq($("#modify").prop("selectedIndex")).attr("value");
	   
	   //If we are changing the colour
	  if($(this).attr("name")=="red" || $(this).attr("name")=="green" || $(this).attr("name")=="blue"){
	
		  //Modify the colour string for our shape based on the ranges
		  //Much more simple to always change all three.
	
		  $("#" + selectedShape).attr("style","fill:rgb(" + $("#r").prop("value") + "," + $("#g").prop("value") + "," + $("#b").prop("value") + ")");

	  }
	  else{
			//Whichever range input has changed, we change the property of the same name in the shape
		  $("#" + selectedShape).attr($(this).attr("name"),$(this).prop("value"));
	  }
	 
	//Save our changes to the database by passing the current values to the php script
	  		//Inform user of save process start
			 $("#message").text("Saving shapes to database...");
			 //Get key of shape from name
			 var pKey=selectedShape.match(/[0-9]+/g);
			 //Pass all changes via GET
			$.get( "shapes.php", { mode: "update",id: pKey[0],
			width: $("#" + selectedShape).attr("width"),
			height: $("#" + selectedShape).attr("height"),
			x: $("#" + selectedShape).attr("x"),
			y: $("#" + selectedShape).attr("y"),
			red: $("#r").prop("value"),
			green: $("#g").prop("value"),
			blue: $("#b").prop("value")
			} )
			  .done(function( data ) {
				  //Inform user of save
				  $("#message").hide().text("Changes saved in database.").fadeIn("200");
			  });
  
  })
  
  //When we change our shape selection
  $('select').mouseup(function(){
	  //Get the newly selected shape
	  var selectedShape=$("option").eq($("#modify").prop("selectedIndex")).attr("value");
	  //Adjust the sliders to match the selected shape, I think this can be done in less code
	  $('input[name=width]').prop("value",$("#" + selectedShape).attr("width"));
	  $('input[name=height]').prop("value",$("#" + selectedShape).attr("height"));
	  $('input[name=x]').prop("value",$("#" + selectedShape).attr("x"));
	  $('input[name=y]').prop("value",$("#" + selectedShape).attr("y"));
	  var style=$("#" + selectedShape).attr("style");
	  //Extract style information

	  var rgb=style.match(/[0-9]+/g);
	  $('input[name=red]').prop("value",rgb[0]);
	  $('input[name=green]').prop("value",rgb[1]);
	  $('input[name=blue]').prop("value",rgb[2]);
	  
	 
  });
  
  //When the new shape button is pressed

  $('a').click(function(e){
	  e.preventDefault();
	  //Inform user of insert process start
			 $("#message").text("Creating new shape in database...");
			 //Pass all changes via GET
			$.get( "shapes.php", { mode: "insert",
			width: 10,
			height: 10,
			x: 10,
			y: 10,
			red: 254,
			green: 0,
			blue: 0
			} )
			  .done(function( data ) {
				  //Inform user of save
				  $("#message").hide().text("New shape added to database.").fadeIn("200");
				loadShapes();
			  });
  });
  
  function loadShapes(){
  //Load shapes from MySQL via AJAX
	//Inform user of AJAX load start
	 $("#message").text("Loading shapes from database...");
	  //We get the shapes from a PHP script which searches the database and formats the data
		  $( "#drawing" ).load( "shapes.php", function() {
			//Display an update on the screen Google Docs style!
			 $("#message").hide().text("Shapes loaded from database.").fadeIn("200");

			 //Add shapes to the shape selection menu
	var menuHTML='';

		for(var i=0;i<$('rect').size();i++){
			menuHTML=menuHTML + '<option value="' + $('rect').eq(i).attr("id") + '">' + $('rect').eq(i).attr("id") + '</option>'
		}

		$('#modify').html(menuHTML);
			//Update sliders
	$('select').eq(0).trigger('mouseup');
			});

	
  }
	  loadShapes();
	});
