function create_cookie(name, value, daysToExpire, path) {
  var date = new Date();
  date.setTime(date.getTime() + (daysToExpire * 24 * 60 * 60 * 1000));
  var expires = date.toUTCString();
  document.cookie = name + '=' + value + ';' +
                   'expires=' + expires + ';' +
                   'path=' + path + ';';
}

function retrieve_cookie(name) {
  var cookie_value = "",
      current_cookie = "",
      name_expr = name + "=",
      all_cookies = document.cookie.split(';'),
      n = all_cookies.length;

  for(var i = 0; i < n; i++) {
    current_cookie = all_cookies[i].trim();
    if(current_cookie.indexOf(name_expr) == 0) {
      cookie_value = current_cookie.substring(name_expr.length, current_cookie.length);
      break;
    }
  }

  return cookie_value;
}

function delete_cookie(name) {
  document.cookie = name + "=; expires=Thu, 01 Jan 1970 00:00:00 GMT; path=/";
}
