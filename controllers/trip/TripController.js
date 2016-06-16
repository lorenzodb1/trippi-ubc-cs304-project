/*
 * Show Modals
 */
var POST = 'POST';

var TRIPID_ID = "#tripId-id";

// Activity IDs
var CITY_INPUT_ID = "#activity-city-input";
var COUNTRY_INPUT_ID = "#activity-country-input";
var NAME_INPUT_ID = "#activity-activity-name-input";
var PLACE_INPUT_ID = "#activity-activity-place-input";
var COST_INPUT_ID = "#activity-cost-input";
var DATE_INPUT_ID = "#activity-date-input";

function showActivitiesModal( action, index ) {

  if( action == 'add') {
    
    // Clear all inputs 
    $( CITY_INPUT_ID ).val( '' );
    $( COUNTRY_INPUT_ID ).val( '' );
    $( NAME_INPUT_ID ).val( '' );
    $( PLACE_INPUT_ID ).val( '' );
    $( COST_INPUT_ID ).val( '' );
    $( DATE_INPUT_ID ).val( '' );

    $( CITY_INPUT_ID ).prop( 'disabled', false );
    $( COUNTRY_INPUT_ID ).prop( 'disabled', false );
    $( PLACE_INPUT_ID ).prop( 'disabled', false );


  } else {

    $( CITY_INPUT_ID ).prop( 'disabled', true );
    $( COUNTRY_INPUT_ID ).prop( 'disabled', true );
    $( PLACE_INPUT_ID ).prop( 'disabled', true );

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

}
/*
 * Activity Modal 
 */
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
 * Accommodation Modal
 */
var ACC_NAME_INPUT = "#accommodations-name-input";
var ACC_CITY_INPUT = "#accommodations-city-input";
var ACC_COUNTRY_INPUT = "#accommodations-country-input";
var ACC_TYPE_INPUT = "#accommodations-type-input";
var ACC_COST_INPUT = "#accommodations-cost-input";
var ACC_RATING_INPUT = "#accommodations-rating-input";
var ACC_STARTDATE_INPUT = "#accommodations-startDate-input";
var ACC_TODATE_INPUT = "#accommodations-fromDate-input";

function updateAccommodations( ) {
  var GET_INDEX_ID = "#activity-modal-index";
  var index = $( GET_INDEX_ID ).val( );

  var url = "http://localhost/trippi-ubc-cs304-project/public/accommodations";

  var getNameValue = $( ACC_NAME_INPUT ).val( );
  var getCityValue = $( ACC_CITY_INPUT ).val( );
  var getCountryValue = $( ACC_COUNTRY_INPUT ).val( );
  var getTypeValue = $( ACC_TYPE_INPUT ).val( );
  var getCostValue = $( ACC_COST_INPUT ).val( );
  var getRatingValue = $( ACC_RATING_INPUT ).val( );
  var getStartDatValue = $( ACC_STARTDATE_INPUT ).val( );
  var getToDatValue = $( ACC_TODATE_INPUT ).val( );

  createTripForm( POST, url, {
    name: getNameValue,
    city: getCityValue,
    country: getCountryValue,
    type: getTypeValue,
    cost: getCostValue,
    rating: getRatingValue,
    startDate: getStartDatValue,
    toDate: getToDatValue
  });
}


/*
 * Location Modal
 */

// Location IDs
var LOC_CITY1_INPUT_ID = "#location-city1-input";
var LOC_COUNTRY1_INPUT_ID = "#location-country1-input";
var LOC_CITY2_INPUT_ID = "#location-city2-input";
var LOC_COUNTRY2_INPUT_ID = "#location-country2-input";
var LOC_TYPE_INPUT_ID = "#location-type-input";
var LOC_FROMDATE_INPUT_ID = "#location-fromdate-input";
var LOC_TODATE_INPUT_ID = "#location-todate-input";

function updateLocation( action ) { 
  if( action == 'add' ) {
    var url = "http://localhost/trippi-ubc-cs304-project/public/locations";

    var getTripId1Value = $( TRIPID_ID ).text( );
    var getCIty1Value = $( LOC_CITY1_INPUT_ID ).val( );
    var getCountry1Value = $( LOC_COUNTRY1_INPUT_ID ).val( );
    var getCIty2Value = $( LOC_CITY2_INPUT_ID ).val( );
    var getCountry2Value = $( LOC_COUNTRY2_INPUT_ID ).val( );
    var getTypeValue = $( LOC_TYPE_INPUT_ID ).val( );
    var getFromDateValue = $( LOC_FROMDATE_INPUT_ID ).val( );
    var getToDateValue = $( LOC_TODATE_INPUT_ID ).val( );

    if( getTypeValue && getFromDateValue && getToDateValue ) {
   
      createTripForm( POST, url, {
        tripID: getTripId1Value,
        city1: getCIty1Value,
        country1: getCountry1Value,
        city2: getCIty2Value,
        country2: getCountry2Value,
        type: getTypeValue,
        fromDate: getFromDateValue,
        toDate: getToDateValue
      });

    }

  } 
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