var Game = (function(){
  
  var log_div = null;
  var load_div = null;
  var actions_div = null;
  var hero_div = null;
  var name_div = null;
  var main_div = null;
  
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

  function processHero(hero){
    var t = '<table>';
    $.each(hero, function(i, val) {
      t += '<tr><td>'+i+'</td><td>'+val+'</td></tr>';
    });
    t += '</table>';
    hero_div.html(t);    
  }

  function processData(data) {
    if (data.name){
      name_div.html(data.name);
    }
    if (data.description){ 
      main_div.html(data.description);
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
    if (raw.hero){
      processHero(raw.hero)
    }    
    wait(false);
  }

  function initGame(){
    log_div = $('#log');
    actions_div = $('#actions');
    hero_div = $('#hero');
    main_div = $('#main');
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