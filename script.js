//This is where the JQuery function calls will happen

$( document ).ready(function() {
	//When any of our range inputs are changed
  $('input[type=range]').change(function(){
	  //This gets the index of the selected option from the dropdown list, 
	  //then selects the object from the list of options, and gets the value
	   var selectedShape=$("option").eq($("#modify").prop("selectedIndex")).attr("value");
	   
	   //If we are changing the colour
	  if($(this).attr("name")=="red" || $(this).attr("name")=="green" || $(this).attr("name")=="blue"){
	
		  //Modify the colour string for our shape based on the ranges
		  //Much more simple to always change all three.
	
		  $("#shape" + selectedShape).attr("style","fill:rgb(" + $("#r").prop("value") + "," + $("#g").prop("value") + "," + $("#b").prop("value") + ")");
		//console.log("fill:rgb(" + $("#r").attr("value") + "," + $("#g").attr("value") + "," + $("#b").attr("value") + ")");
		  //console.log($("option").eq($("#modify").prop("selectedIndex")).attr("value"));
	  }
	  else{
			//Whichever range input has changed, we change the property of the same name in the shape
		 // console.log("#" + selectedShape);
		  $("#shape" + selectedShape).attr($(this).attr("name"),$(this).prop("value"));
	  }
	  console.log($("#r").attr("value"));
	//Save our changes to the database by passing the current values to the php script
	  		$.get( "shapes.php", { mode: "update",id: selectedShape,
			width: $("#shape" + selectedShape).attr("width"),
			height: $("#shape" + selectedShape).attr("height"),
			x: $("#shape" + selectedShape).attr("x"),
			y: $("#shape" + selectedShape).attr("y"),
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
  $('select').change(function(){
	  //Get the newly selected shape
	  var selectedShape=$("option").eq($("#modify").prop("selectedIndex")).attr("value");
	  //Adjust the sliders to match the selected shape, I think this can be done in less code
	  $('input[name=width]').prop("value",$("#shape" + selectedShape).attr("width"));
	  $('input[name=height]').prop("value",$("#shape" + selectedShape).attr("height"));
	  $('input[name=x]').prop("value",$("#shape" + selectedShape).attr("x"));
	  $('input[name=y]').prop("value",$("#shape" + selectedShape).attr("y"));
	  var style=$("#shape" + selectedShape).attr("style");
	  //Extract style information
	  var rgb=style.match(/[0-9]+/g);
	  $('input[name=red]').prop("value",rgb[0]);
	  $('input[name=green]').prop("value",rgb[1]);
	  $('input[name=blue]').prop("value",rgb[2]);
	  
	   
	 
  });
  
  //When the new shape button is pressed
  $('#newshape').click(function(){
	  
	  
  });
  //Load shapes from MySQL via AJAX
	
	  //We get the shapes from a PHP script which searches the database and formats the data
		  $( "#drawing" ).load( "shapes.php", function() {
			//Display an update on the screen Google Docs style!
			 $("#message").hide().text("Shapes loaded from database.").fadeIn("200");
			});
			
	//Trigger the event which matches the range sliders to the current shape
	 $('select').trigger("change");
	  
	});
