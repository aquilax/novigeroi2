var Game = (function(){
  
  var log_div = null;
  
  function wait(show){
    if (show){
      $('#load').show();
    } else {
      $('#load').hide();
    }
  }
  
  function get(url) {
    wait(true);
    $.get(url, processData, 'json');
  }

  function log(data) {
    log_div.append(data);
  }

  function processActions(action) {
    var t = '';
    for (var i in action){
      t += '<a href='+action[i].controller+'>'+action[i].message+'</a><br />';
    }
    $('#actions').html(t);
  }

  function processData(raw) {
    log(raw);
    if (raw.action){
      processActions(raw.action)
    }
    wait(false);
  }

  function initGame(){
    get('/v1/town/getPlaces');
    log_div = $('#log');
  }
    
  function handleAnchors (event) {
    action($(event.target).attr('href'));
    event.preventDefault();
  }
    
  function action (href) {
    get(href);
  }
  
  return {
    init: initGame,
    handleAnchors: handleAnchors
  };
}());

$(document).ready(function(){
  $("a").live('click', Game.handleAnchors);
  Game.init();
});