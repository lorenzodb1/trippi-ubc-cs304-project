// Makes the current Tab Active
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
    'search-for-users-trips'
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

  } else {

  }
}

function searchByUserName() {
  var INPUTIDS = [
    'search-by-username-input-1'
  ]

  var userName = document.getElementById(INPUTIDS[0]).value;
  var URL = "http://localhost/trippi-ubc-cs304-project/public/search/users";

  createForm(URL, { queryFunction: "searchUserByUserName",
    username: userName
  });

}

function searchByUsersName() {
  var INPUTIDS = [
    'search-by-users-name-input-1'
  ]

  var usersName = document.getElementById(INPUTIDS[0]).value;
  var URL = "http://localhost/trippi-ubc-cs304-project/public/search/users";

  createForm(URL, { queryFunction: "searchByUsersName",
    name: usersName
  });
}

function searchByUserEmail() {
  var INPUTIDS = [
    'search-by-users-email-input-1'
  ]

  var email = document.getElementById(INPUTIDS[0]).value;
  var URL = "http://localhost/trippi-ubc-cs304-project/public/search/users";

  createForm(URL, { queryFunction: "searchByUsersEmail",
    email: email
  });
}

function searchByUserRating() {
  var INPUTIDS = [
    'search-by-users-rating-input-1'
  ]

  var rating = document.getElementById(INPUTIDS[0]).value;
  var URL = "http://localhost/trippi-ubc-cs304-project/public/search/users";

  createForm(URL, { queryFunction: "searchByUserRating",
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

  createForm(URL, { queryFunction: "searchByUserLocation",
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

  createForm(URL, { queryFunction: "searchByUsersInTrip",
    tripId: tripId
  });
}

function searchByUsersTravelledToLocation() {
  var INPUTIDS = [
    'search-by-users-travelled-to-location-input-1'
  ]

  var city = document.getElementById(INPUTIDS[0]).value;

  var URL = "http://localhost/trippi-ubc-cs304-project/public/search/users";

  createForm(URL, { queryFunction: "searchByUsersTravelledToLocation",
    city: city
  });
}



function createForm(requestURL, items) {
  var name,
      form = document.createElement("form"),
      node = document.createElement("input");
    
  form.action = requestURL;

  for(name in items) {
    node.name  = name;
    node.value = items[name].toString();
    form.appendChild(node.cloneNode());
  }

  // To be sent, the form needs to be attached to the main document.
  form.style.display = "none";
  document.body.appendChild(form);

  form.submit();
}


function submitQuery() {

}