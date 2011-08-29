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
    var n=0, e=0, s=0, w=0;
    if (_queue.length > 0) {
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

  function dorender(c){
    console.log(c);
    var b = '';
    for (var y = 0; y < 20; y++) {
      for (var x = 0; x < 50; x++) {
        if ((y in _cache) && (x in _cache[y])) {
          b += _cache[y][x];
        } else {
          b += '.';
        }
      }
      b += "\n";
    }
    $('#c').html(b);
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

var coord = [8,6];

$(document).ready(function(){
  Maps.init(5,5);
  Maps.render(coord[0], coord[1]);
  $('.b').click(function(event){
    coord = Maps.move(coord, $(event.target).attr('rel'));
    event.preventDefault();
  })
  
})
