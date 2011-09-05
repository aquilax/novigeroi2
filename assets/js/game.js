var Maps = (function(){
  var _cache = {};
  var _queue = []
  var w = 0;
  var hw = 0;
  var h = 0;
  var hh = 0;

  var render_x = 0;
  var render_y = 0;
  
  function init(width, height){
    w = width;
    hw = parseInt((w-1)/2);
    h = height;
    hh = parseInt((h-1)/2);
  }

  function processData(wn, es, data){
    var n = 0;
    for (var dy = wn[1]; dy <= es[1]; dy++) {
      for (var dx = wn[0]; dx <= es[0]; dx++) {
        if (_cache[dy] == undefined) {
          _cache[dy] = {}
        }
        _cache[dy][dx] = data.m[n];
        n++;
      }
    }
    dorender(c)
  }

  function genUrl(wn, es){
    return 'v1/map/get/'+wn[0]+'/'+wn[1]+'/'+es[0]+'/'+es[1]+'';
  }

  function fetch(wn, es){
    var url = genUrl(wn, es);
    $.getJSON(url, function(data){
      processData(wn, es, data)
    });
  }

  function qpush(center){
    _queue.push(center)
  }

  function qfetch(){
    if (_queue.length > 0) {
      var n = Number.MAX_VALUE;
      var e = Number.MIN_VALUE;
      var s = Number.MIN_VALUE;
      var w = Number.MAX_VALUE;      
      while (c = _queue.shift()) {
        if (c[1] > s) s = c[1];
        if (c[1] < n) n = c[1];
        if (c[0] > e) e = c[0];
        if (c[0] < w) w = c[0];
      }
      //get fetch coordinates
      fetch([w,n], [e,s]);
    } else {
      dorender();
    }
  }

  function dorender(){
    var c = '';
    for (var y = 0; y < h; y++) {
      for (var x = 0; x < w; x++) {
        var ry = (render_y-hh)+y;
        var rx = (render_x-hw)+x;
        if ((ry in _cache) && (rx in _cache[ry])) {
          c = _cache[ry][rx];
        } else {
          c = '.';
        }
        $('#map').find('#c_'+x+'_'+y).html(c);
      }
    }
  }

  function render(x, y){
    render_x = x;
    render_y = y;
    for (var ry = y-hh; ry < y+hh+1; ry++) {
      for (var rx = x-hw; rx < x+hw+1; rx++) {
        if (!(ry  in _cache) || !(rx in _cache[ry])) {
          qpush([rx, ry]);
        }
      }
    }
    qfetch();
  }
  
  function move(coord, direction){
    //init coordinates with the old ones
    var nx = coord[0];
    var ny = coord[1];
    switch (direction){
      case 'n': ny--; break;
      case 'e': nx++; break;
      case 's': ny++; break;
      case 'w': nx--; break;
    }
    render(nx, ny);
    return [nx, ny];
  }

  return {
    init: init,
    render: render,
    move: move
  }
}());

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
      GTmpl.render(templateProcess(raw), raw.hero.status);
      if (raw.hero.status == 'explore') {
        Maps.render(raw.hero.map_x, raw.hero.map_y);
      }
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
    Maps.init(9, 9);
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
    $(this).prepend("Error requesting page <a target='_blank' href='"+settings.url+"'>" + settings.url + "</a><br />");
  });
});
