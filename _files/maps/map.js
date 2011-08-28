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

  function processData(cx, cy, data){
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
  }

  function fetch(rx, ry){
    $.getJSON('map.json', function(data){
      processData(rx, ry, data)
    });
  }

  function qpush(center){
    _queue.push(center)
  }

  function qfetch(){
    while (c = _queue.shift()) {
      fetch(c[0], c[1]);
    }
  }

  function render(x, y){
    for (var ry = y-hh; ry < y+hh; ry++) {
      for (var rx = x-hw; rx < x+hw; rx++) {
        if ((ry in _cache) && (rx in _cache[ry])) {
          console.log(_cache[ry][rx])
        } else {
          qpush([rx, ry]);
        }
      }
    }
    qfetch();
    console.log(_cache)
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
