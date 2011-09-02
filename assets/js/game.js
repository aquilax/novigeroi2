var GTmpl = (function(){

  var target_el = null;
  var last_template = null;
  var _cache = {};

  function populate(data){
    for (id in data){
      if (typeof(_cache[id]) != 'undefined'){
        _cache[id].html(data[id]);
      } else {
        var el = target_el.find('#'+id);
        if (typeof(el) != 'undefined'){
          _cache[id] = el;
          el.html(data[id]);
        }
      }
    }
  }

  function init(target) {
    target_el = $(target);
  }

  function getTemplate(template) {
    if (typeof(tmpl[template]) == "undefined"){
      template = 'default';
    }
    return tmpl[template];
  }

  function render(data, template, target) {
    var rtarget;
    if (typeof(target) != 'undefined'){
      rtarget = $(target);
    } else {
      rtarget = target_el
    }
    if (template != last_template){
      // render template
      rtarget.html(getTemplate(template));
      _cache = {}
    }
    populate(data);
    last_template = template;
  }

  return {
    init: init,
    render: render
  };
}());

var Game = (function(){
  
  var log_div = null;
  var debug_div = null;
  var load_div = null;
  var actions_div = null;
  var hero_div = null;
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
    debug_div.prepend('['+ts+'] '+recp(data)+'<br/>');
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
    if (data.message){ 
      log_div.append(data.message);
    }
  }

  function templateProcess(data){
    switch (data.hero.status) {
      case 'fight': return data.main;
      default: return data.main;
    }
  }

  function processResponse(raw) {
    log(raw);
    if (raw.redirect){
      get(raw.redirect);
      return;
    }
    if (raw.title){
      name_div.html(raw.title)
    }    
    if (raw.act){
      processActions(raw.act)
    }
    if (raw.log){
      for (i in raw.log){
        log_div.prepend("<li>"+raw.log[i]+"</li>");
      }
    }
    if (raw.hero){
      processHero(raw.hero)
    }    
    if (raw.hero.status){
      GTmpl.render(templateProcess(raw), raw.hero.status)
    }
    wait(false);
  }

  function initGame(){
    log_div = $('#log');
    debug_div = $('#debug');
    actions_div = $('#act');
    hero_div = $('#hero');
    main_div = $('#main');
    load_div = $('#load');
    name_div = $('#title');
    GTmpl.init('#main');
    //get in the action
    get('v1/game');
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
  $("#debug").ajaxError(function(event, request, settings){
    $(this).prepend("Error requesting page " + settings.url + "<br />");
  });
});
