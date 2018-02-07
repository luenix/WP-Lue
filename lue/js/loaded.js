function loaded(selector, callback){
  //trigger after page load.
  jQuery(function () {
    callback(jQuery(selector));
  });
  //trigger after page update eg ajax event or jquery insert.
  jQuery(document).on('DOMNodeInserted', selector, function () {
    callback(jQuery(this));
  });
}
