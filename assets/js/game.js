var Game = (function(){
  
  var log_div = null;
  var load_div = null;
  var actions_div = null;
  var name_div = null;
  
  function wait(show){
    if (show){
      load_div.show();
    } else {
      load_div.hide();
    }
  }
  
  function get(url) {
    wait(true);
    $.get(url, processResponse, 'json');
  }

  function recp(data){
    var t = '';
    if (typeof(data) == 'object'){
      $.each(data, function(i, val) {
        t += ('<b>'+i+"</b> : {" + recp(val)+"} ");
      });
    } else {
      t = data;
    }
    return t;
  }

  function log(data) {
    var ts = new Date().toString();
    log_div.prepend('['+ts+'] '+recp(data)+'<br/>');
  }

  function processActions(action) {
    var t = '';
    for (var i in action){
      t += '<a href='+action[i].controller+'>'+action[i].message+'</a><br />';
    }
    actions_div.html(t);
  }

  function processData(data) {
    if (data.name){
      name_div.html(data.name);
    }
  }

  function processResponse(raw) {
    log(raw);
    if (raw.redirect){
      get(raw.redirect);
      return;
    }
    if (raw.action){
      processActions(raw.action)
    }
    if (raw.data){
      processData(raw.data)
    }    
    wait(false);
  }

  function initGame(){
    log_div = $('#log');
    actions_div = $('#actions');
    load_div = $('#load');
    name_div = $('#title');
    //get in the action
    get('/v1/game');
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
  $("#log").ajaxError(function(event, request, settings){
    $(this).prepend("Error requesting page " + settings.url + "<br />");
  });
});