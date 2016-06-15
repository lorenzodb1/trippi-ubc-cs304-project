// Makes the current Tab Active
var response = null;
var numResultROws = 0;
var GET = 'GET';

function makeActive(id) {

  var TABTITLES = [
    'users-tab',
    'trips-tab',
    'accommodations-tab',
    'activities-tab'
  ];

  var CONTENTTITLES = [
    'users-content',
    'trips-content',
    'accomodations-content',
    'activities-content'
  ];

  document.getElementById(id).className = "active";

  for (var i=0; i < TABTITLES.length; i++) {
    if(id != TABTITLES[i]) {
      document.getElementById(TABTITLES[i]).className = "";
      document.getElementById(CONTENTTITLES[i]).style = "display: none;"
    } else {
      document.getElementById(CONTENTTITLES[i]).style = "display: block;"
    }

  }
}

function checkWhichQuery() {
  var RADIOBUTTONS = [
    'search-by-username',
    'search-by-users-name',
    'search-by-user-email',
    'search-by-user-rating',
    'search-by-user-dob',
    'search-by-user-location',
    'search-by-users-in-trip',
    'search-by-users-travelled-to-location',
    'search-for-users-trips',
    'search-for-max-trip-rating',
    'search-for-min-trip-rating',
    'search-for-avg-trip-rating',
    'search-for-incomplete-trips',
    'search-for-complete-trips',
    'search-for-all-users-on-trip',
    'search-for-all-trips-starting-from',
    'search-for-all-trips-by-equal-duration',
    'search-for-all-trips-by-greater-duration',
    'search-for-all-trips-by-lesser-duration'
  ];

  if( document.getElementById(RADIOBUTTONS[0]).checked ) {
    searchByUserName();
  } else if (document.getElementById(RADIOBUTTONS[1]).checked ) {
    searchByUsersName();
  } else if (document.getElementById(RADIOBUTTONS[2]).checked ) {
    searchByUserEmail();
  } else if (document.getElementById(RADIOBUTTONS[3]).checked ) {
    searchByUserRating();
  } else if (document.getElementById(RADIOBUTTONS[4]).checked ) {
    // search by birthday
  } else if (document.getElementById(RADIOBUTTONS[5]).checked ) {
    searchByUserLocation();
  } else if (document.getElementById(RADIOBUTTONS[6]).checked ) {
    searchByUsersInTrip();
  } else if (document.getElementById(RADIOBUTTONS[7]).checked ) {
    searchByUsersTravelledToLocation();
  } else if (document.getElementById(RADIOBUTTONS[8]).checked ) {
    // All of a user's trips
  } else if (document.getElementById(RADIOBUTTONS[9]).checked ) {
    searchForMaxRatedTrip();
  } else if (document.getElementById(RADIOBUTTONS[10]).checked ) {
    searchForMinRatedTrip();
  } else if (document.getElementById(RADIOBUTTONS[11]).checked ) {
    searchForAvgRatedTrip();
  } else if (document.getElementById(RADIOBUTTONS[12]).checked ) {
    searchIncompleteTrips();
  } else if (document.getElementById(RADIOBUTTONS[13]).checked ) {
    searchCompleteTrips();
  } else if (document.getElementById(RADIOBUTTONS[14]).checked ) {
    searchForAllUsersOnTrip();
  } else if (document.getElementById(RADIOBUTTONS[15]).checked ) {
    searchForAllTripsStartingFrom();
  } else if (document.getElementById(RADIOBUTTONS[16]).checked ) {
    searchTripsByEqualDuration();
  } else if (document.getElementById(RADIOBUTTONS[17]).checked ) {
    searchTripsByGreaterDuration();
  } else if (document.getElementById(RADIOBUTTONS[18]).checked ) {
    searchTripsByLesserDuration();
  } else {

  }
}

/*** USERS ***/
function searchByUserName() {
  var INPUTIDS = [
    'search-by-username-input-1'
  ]

  var userName = document.getElementById(INPUTIDS[0]).value;
  var URL = "http://localhost/trippi-ubc-cs304-project/public/search/users";

  createSearchForm(GET, URL, { queryFunction: "searchUserByUserName",
    username: userName
  });

}

function searchByUsersName() {
  var INPUTIDS = [
    'search-by-users-name-input-1'
  ]

  var usersName = document.getElementById(INPUTIDS[0]).value;
  var URL = "http://localhost/trippi-ubc-cs304-project/public/search/users";

  createSearchForm(GET, URL, { queryFunction: "searchByUsersName",
    name: usersName
  });
}

function searchByUserEmail() {
  var INPUTIDS = [
    'search-by-users-email-input-1'
  ]

  var email = document.getElementById(INPUTIDS[0]).value;
  var URL = "http://localhost/trippi-ubc-cs304-project/public/search/users";

  createSearchForm(GET, URL, { queryFunction: "searchByUsersEmail",
    email: email
  });
}

function searchByUserRating() {
  var INPUTIDS = [
    'search-by-users-rating-input-1'
  ]

  var rating = document.getElementById(INPUTIDS[0]).value;
  var URL = "http://localhost/trippi-ubc-cs304-project/public/search/users";

  createSearchForm(GET, URL, { queryFunction: "searchByUserRating",
    rating: rating
  });
}

function searchByUserLocation() {
  var INPUTIDS = [
    'search-by-users-location-input-1',
    'search-by-users-location-input-2'
  ]

  var city = document.getElementById(INPUTIDS[0]).value;
  var country = document.getElementById(INPUTIDS[1]).value;

  var URL = "http://localhost/trippi-ubc-cs304-project/public/search/users";

  createSearchForm(GET, URL, { queryFunction: "searchByUserLocation",
    city: city,
    country: country
  });
}

function searchByUsersInTrip() {
  var INPUTIDS = [
    'search-by-users-in-trip-input-1'
  ]

  var tripId = document.getElementById(INPUTIDS[0]).value;

  var URL = "http://localhost/trippi-ubc-cs304-project/public/search/users";

  createSearchForm(GET, URL, { queryFunction: "searchByUsersInTrip",
    tripId: tripId
  });
}

function searchByUsersTravelledToLocation() {
  var INPUTIDS = [
    'search-by-users-travelled-to-location-input-1'
  ]

  var city = document.getElementById(INPUTIDS[0]).value;

  var URL = "http://localhost/trippi-ubc-cs304-project/public/search/users";

  createSearchForm(GET, URL, { queryFunction: "searchByUsersTravelledToLocation",
    city: city
  });
}

/*** TRIPS ***/
function searchForMaxRatedTrip() {
  var URL = "http://localhost/trippi-ubc-cs304-project/public/search/trips";

  createSearchForm(GET, URL, { queryFunction: "searchForMaxRatedTrip"});
}

function searchForMinRatedTrip() {
  var URL = "http://localhost/trippi-ubc-cs304-project/public/search/trips";

  createSearchForm(GET, URL, { queryFunction: "searchForMinRatedTrip"});
}

function searchForAvgRatedTrip() {
  var URL = "http://localhost/trippi-ubc-cs304-project/public/search/trips";

  createSearchForm(GET, URL, { queryFunction: "searchForAvgRatedTrip"});
}

function searchIncompleteTrips() {
  var URL = "http://localhost/trippi-ubc-cs304-project/public/search/trips";

  createSearchForm(GET, URL, { queryFunction: "searchIncompleteTrips"});
}

function searchCompleteTrips() {
  var URL = "http://localhost/trippi-ubc-cs304-project/public/search/trips";

  createSearchForm(GET, URL, { queryFunction: "searchCompleteTrips"});
}

function searchForAllUsersOnTrip() {
  var INPUTIDS = [
    'search-for-all-users-on-trip-input-1'
  ]

  var tripId = document.getElementById(INPUTIDS[0]).value;

  var URL = "http://localhost/trippi-ubc-cs304-project/public/search/trips";

  createSearchForm(GET, URL, { queryFunction: "searchForAllUsersOnTrip",
    tripId: tripId
  });
}

function searchForAllTripsStartingFrom() {
  var INPUTIDS = [
    'search-for-all-trips-starting-from-input-1'
  ]

  var startLocation = document.getElementById(INPUTIDS[0]).value;

  var URL = "http://localhost/trippi-ubc-cs304-project/public/search/trips";

  createSearchForm(GET, URL, { queryFunction: "searchForAllTripsStartingFrom",
    startLocation: startLocation
  });
}

function searchTripsByEqualDuration() {
  var INPUTIDS = [
    'search-for-all-trips-by-equal-duration-input-1'
  ]

  var duration = document.getElementById(INPUTIDS[0]).value;

  var URL = "http://localhost/trippi-ubc-cs304-project/public/search/trips";

  createSearchForm(GET, URL, { queryFunction: "searchTripsByEqualDuration",
    duration: duration
  });
}

function searchTripsByGreaterDuration() {
  var INPUTIDS = [
    'search-for-all-trips-by-greater-duration-input-1'
  ]

  var duration = document.getElementById(INPUTIDS[0]).value;

  var URL = "http://localhost/trippi-ubc-cs304-project/public/search/trips";

  createSearchForm(GET, URL, { queryFunction: "searchTripsByGreaterDuration",
    duration: duration
  });
}

function searchTripsByLesserDuration() {
  var INPUTIDS = [
    'search-for-all-trips-by-lesser-duration-input-1'
  ]

  var duration = document.getElementById(INPUTIDS[0]).value;

  var URL = "http://localhost/trippi-ubc-cs304-project/public/search/trips";

  createSearchForm(GET, URL, { queryFunction: "searchTripsByLesserDuration",
    duration: duration
  });
}


/*** HELPERS ***/
function createSearchForm(requestType, requestURL, JSONObj) {
  $.ajax({  
    type: requestType,  
    url: requestURL, 
    data: JSONObj,
    success: searchResponseHandler
  });

  clearResultTable();
}

function searchResponseHandler(returnedResponse) {
  response = JSON.parse(returnedResponse);

  if( response ) {

    // Add a new row for each item in the response 
    $.each( response , function( index, item ) {
      var tripId = ((item.tripId) ? item.tripId : ((item.tripID) ? item.tripID : "" ) );
      var tripName = ((item.tripName) ? item.tripName : "" );
      var rating = ((item.rating) ? item.rating : "" );
      var comment = ((item.comment) ? item.comment : "" );
      var startDate = ((item.startDate) ? item.startDate : "" );
      var endDate = ((item.endDate) ? item.endDate : "" );
      var duration = ((item.duration) ? item.duration : "" );
      var startLocation = ((item.startLocation) ? item.startLocation : "" );
      var usersName = ((item.name) ? item.name : "" );
      var userName = ((item.username) ? item.username : "" );
      var hometown = ((item.hometown) ? item.hometown : "" );
      var country = ((item.country) ? ", " + item.country : "" );
      var dob = ((item.dateOfBirth) ? item.dateOfBirth : "" );
      var aboutMe = ((item.aboutMe) ? item.aboutMe : "" );

      var row = $("<tr id='result-" + (numResultROws+1) + "'>" +
        "<td>" + tripId + "</td>" +
        "<td colspan='2'>" + tripName  + "</td>" +
        "<td>" + rating + "</td>" +
        "<td colspan='4'>" + comment + "</td>" +
        "<td>" + startDate + "</td>" +
        "<td>" + endDate + "</td>" +
        "<td>" + duration + "</td>" +
        "<td>" + startLocation + "</td>" +
        "<td>" + usersName + "</td>" +
        "<td>" + userName + "</td>" +
        "<td>" + hometown, country + "</td>" +
        "<td>" + dob + "</td>" +
        "<td> colspan='4'" + aboutMe + "</td>" +
        "</tr>");

      $("#trip-results-panel-inner > tbody").append(row);
      numResultROws++;

    });
  }
}

function clearResultTable() {
  while( numResultROws >= 0 ) {
    $("#result-" + (numResultROws) ).remove();
    numResultROws--;
  }

  numResultROws = 0;
}


      

