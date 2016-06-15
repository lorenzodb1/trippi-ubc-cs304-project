/*
 * Show Modals
 */
var POST = 'POST';

// Modal IDs
var CITY_INPUT_ID = "#activity-city-input";
var COUNTRY_INPUT_ID = "#activity-country-input";
var NAME_INPUT_ID = "#activity-activity-name-input";
var PLACE_INPUT_ID = "#activity-activity-place-input";
var COST_INPUT_ID = "#activity-cost-input";
var DATE_INPUT_ID = "#activity-date-input";

function showActivitiesModal( index ) {
  var GET_INDEX_ID = "#activity-modal-index";
  $( GET_INDEX_ID ).val( index );

  // DB Values
  var GET_CITY_ID = "activity-city-" + index;
  var GET_COUNTRY_ID = "activity-country-" + index;
  var GET_NAME_ID = "activity-activity-name-" + index;
  var GET_PLACE_ID = "activity-activity-place-" + index;
  var GET_COST_ID = "activity-cost-" + index;
  var GET_DATE_ID = "activity-date-" + index;

  var getCItyValue = document.getElementById( GET_CITY_ID ).innerHTML;
  var getCountryValue = document.getElementById( GET_COUNTRY_ID ).innerHTML;
  var getNameValue = document.getElementById( GET_NAME_ID ).innerHTML;
  var getPlaceValue = document.getElementById( GET_PLACE_ID ).innerHTML;
  var getCostValue = document.getElementById( GET_COST_ID ).innerHTML;
  var getDateValue = document.getElementById( GET_DATE_ID ).innerHTML;

  $( CITY_INPUT_ID ).val( getCItyValue );
  $( COUNTRY_INPUT_ID ).val( getCountryValue );
  $( NAME_INPUT_ID ).val( getNameValue );
  $( PLACE_INPUT_ID ).val( getPlaceValue );
  $( COST_INPUT_ID ).val( getCostValue );
  $( DATE_INPUT_ID ).val( getDateValue );

}

function updateActivity( ) {
  var GET_INDEX_ID = "#activity-modal-index";
  var index = $( GET_INDEX_ID ).val( );

  var url = "http://localhost/trippi-ubc-cs304-project/public/activities";

  var getCItyValue = $( CITY_INPUT_ID ).val( );
  var getCountryValue = $( COUNTRY_INPUT_ID ).val( );
  var getNameValue = $( NAME_INPUT_ID ).val( );
  var getPlaceValue = $( PLACE_INPUT_ID ).val( );
  var getCostValue = $( COST_INPUT_ID ).val( );
  var getDateValue = $( DATE_INPUT_ID ).val( );

  createTripForm( POST, url, {
    city: getCItyValue,
    country: getCountryValue,
    acitivtyName: getNameValue,
    place: getPlaceValue,
    cost: getCostValue,
    date: getDateValue
  });
}


/*
 * Helpers
 */
function createTripForm( requestType, requestURL, JSONObj)  {
  $.ajax({  
    type: requestType,  
    url: requestURL, 
    data: JSONObj,
    success: tripResponseHandler
  });
}

function tripResponseHandler( response ) {
  location.reload();
}