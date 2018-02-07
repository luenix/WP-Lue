function getParameterByName(name) {
  var match = new RegExp('[\\?&]' + name + '=([^&#/]*)').exec(window.location.search);
  return match && decodeURIComponent(match[1].replace(/\+/g, ' ')).replace('\u200E', '');
}

jQuery(document).ready(function () {
  if( navigator.cookieEnabled ) {
    if( getParameterByName("ref") && !retrieve_cookie("referral_link") ) {
      create_cookie("referral_link", window.location.href, 30, "/");
    }
  }
});
