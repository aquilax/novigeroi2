var Maps = (function(){
  var _cache = {};
  var _queue = []
  var w = 0;
  var hw = 0;
  var h = 0;
  var hh = 0;

  function init(width, height){
    w = width;
    hw = parseInt((w-1)/2);
    h = height;
    hh = parseInt((h-1)/2);
    fetch(hw,hh);
  }

  function processData(cx, cy, data, c){
    var dhh = parseInt((data.h - 1)/2);
    var dhw = parseInt((data.w - 1)/2);
    var n = 0;
    for (var dy =cy-dhh; dy <= cy+dhh; dy++) {
      for (var dx = cx-dhw; dx <= cx+dhh; dx++) {
        if (_cache[dy] == undefined) {
          _cache[dy] = {}
        }
        _cache[dy][dx] = data.m[n];
        n++;
      }
    }
    dorender(c)
  }

  function fetch(rx, ry, c){
    $.getJSON('map.json', function(data){
      processData(rx, ry, data, c)
    });
  }

  function qpush(center){
    _queue.push(center)
  }

  function qfetch(x,y){
    var n, e, s, w = 0;
    if (_queue.len() > 0) {
      while (c = _queue.shift()) {
        if (c[1] > s) s = c[1];
        if (c[1] < n) n = c[1];
        if (c[0] > e) e = c[0];
        if (c[0] < w) w = c[0];
      }
      ny = s-n;
      nx = e-w;
      fetch(nx, ny, [x, y]);
    } else {
      dorender([x, y]);
    }
  }

  function render(x, y){
    for (var ry = y-hh; ry < y+hh; ry++) {
      for (var rx = x-hw; rx < x+hw; rx++) {
        if ((ry in _cache) && (rx in _cache[ry])) {
        } else {
          qpush([rx, ry]);
        }
      }
    }
    qfetch(x,y);
  }

  return {
    init: init,
    render: render
  }
}());

$(document).ready(function(){
  Maps.init(3,3);
  Maps.render(2,2);
  Maps.render(2,1);
})
