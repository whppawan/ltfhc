// JavaScript Document

<!----------------------Alphabet Only Condition Start------------------------------>
function alphabet_only(e) 
{
	var val = document.getElementById(e).value;
	var val_length=val.length;
    if (!val.match(/^[a-zA-Z ]*$/)) 
    {
        document.getElementById(e).value=val.substring(0, val_length-1);
		return false;
    }
    return true;
}
<!----------------------Alphabet Only Condition End------------------------------>

<!----------------------Numeric Only Condition Start------------------------------>
function isNumericKey(e)
{
    if (window.event) { var charCode = window.event.keyCode; }
    else if (e) { var charCode = e.which; }
    else { return true; }
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {alert("PLease Enter Numeric"); return false; }
    return true;
}
<!----------------------Numeric Only Condition End------------------------------>

<!----------------------Float Only Condition Start------------------------------>
function CheckDecimal(id)   
{
 var inputtxt=document.getElementById(id).value;
 var decimal=  /^[-+]?[0-9]+\.[0-9]+$/;   
 if(!inputtxt.match(decimal) && inputtxt && inputtxt!=0)   
 {
  window.setTimeout(function(){document.getElementById(id).focus();}, 0);
  alert('Please enter the correct value');
  return false;  
 }  
}
<!----------------------Float Only Condition End------------------------------>

<!----------------------Mobile Number Validation : Start------------------------------>
function mobile_no_validation(mobile)
{
 var mobile_value=document.getElementById(mobile).value;
 var length=mobile_value.length;
 if(length!=10 && mobile_value!="")
 {
  alert("Please Enter 10 Digit Valid Phone Number");
  document.getElementById(mobile).focus();
  return false
 }
}
<!----------------------Mobile Number Validation : End------------------------------>

<!----------------------E-Mail Validation : Start------------------------------>
function email_validation(email)
{
 var x=document.getElementById(email).value;
 var atpos=x.indexOf("@");
 var dotpos=x.lastIndexOf(".");
 if ((atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length) && x!="")
 {
  alert("Please Enter the Valid E-Mail Address");
  document.getElementById(email).focus();
  return false;
 }
}
<!----------------------E-Mail Validation : End------------------------------>

<!----------------------Date Validation : Start------------------------------>
function date_validation(d1, d2)
{
 var date1 = Date.parse(document.getElementById(d1).value);
 if(d2)
  var date2 = Date.parse(document.getElementById(d2).value);
 else
 {
  var today = new Date();
  var day = today.getDate();
  var month = today.getMonth()+1;
  var year = today.getFullYear();
  var curdate=year+"-"+month+"-"+day;
  var date2 = Date.parse(curdate);
 }
 return(date2-date1);
}
<!----------------------Date Validation : End------------------------------>

<!----------------------Date Function : Start------------------------------>

function fnSetDateFormat(oDateFormat)
{
	oDateFormat['FullYear'];		//Example = 2007
	oDateFormat['Year'];			//Example = 07
	oDateFormat['FullMonthName'];	//Example = January
	oDateFormat['MonthName'];		//Example = Jan
	oDateFormat['Month'];			//Example = 01
	oDateFormat['Date'];			//Example = 01
	oDateFormat['FullDay'];			//Example = Sunday
	oDateFormat['Day'];				//Example = Sun
	oDateFormat['Hours'];			//Example = 01
	oDateFormat['Minutes'];			//Example = 01
	oDateFormat['Seconds'];			//Example = 01

	var sDateString;
	
	//Example = 01/01/00  dd/mm/yy
	//sDateString = oDateFormat['Date'] +"/"+ oDateFormat['Month'] +"/"+ oDateFormat['Year'];		
	
	//Example = 01/01/0000  dd/mm/yyyy
	//sDateString = oDateFormat['Date'] +"/"+ oDateFormat['Month'] +"/"+ oDateFormat['FullYear'];	
	
	//Example = 0000-01-01 yyyy/mm/dd
	sDateString = oDateFormat['FullYear'] +"-"+ oDateFormat['Month'] +"-"+ oDateFormat['Date'];
	
	//Example = Jan-01-0000 Mmm/dd/yyyy
	//sDateString = oDateFormat['MonthName'] +"-"+ oDateFormat['Date'] +"-"+ oDateFormat['FullYear'];
	
	return sDateString;
}
<!----------------------Date Function : End------------------------------>

function validation(email, mobile)
{
 return email_validation(email);
 return mobile_no_validation(mobile);
}

function date_field_enable_disable(value, id)
{
 if(value=="Yes" || value=="Active" || value=="Not Working Provider")
 {
  document.getElementById(id).value="<?php echo $date_of_child_care_corner; ?>";
  document.getElementById(id).disabled=false;
  document.getElementById(id+"_img").style.visibility="visible";
 }
 else
 {
  document.getElementById(id).value="";
  document.getElementById(id).disabled=true;
  document.getElementById(id+"_img").style.visibility="hidden";
 }
}

<!----------------------Selected Colour : Start------------------------------> 
 function selected_color(id)
 {
  var option = document.getElementById(id).options;
  selIndex = document.getElementById(id).selectedIndex
  if(document.getElementById(id).value!="")
  {
   document.getElementById(id).style.background="#FF9966";
   for (var i = 0, length = option.length; i < length; i++)
   {
    if(i==selIndex)
     option[i].style.backgroundColor = '#FF9966';
    else
     option[i].style.backgroundColor = '#FFFFFF';
   }
  }
  else
  {
   document.getElementById(id).style.background="#FFFFFF";
   for (var i = 0, length = option.length; i < length; i++)
   {
    option[i].style.backgroundColor = '#FFFFFF';
   }
  }
 }
<!----------------------Selected Colour : End------------------------------> 