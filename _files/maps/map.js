var Maps = (function(){
  var _cache = [];
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

  function processData(cx, cy, data){
    dhh = parseInt((data.h - 1)/2);
    dhw = parseInt((data.w - 1)/2);
    var n = 0;
    for (var dy = dhh; dy < data.h; dy++) {
      for (var dx = dhw; dx < data.w; dx++) {
        if (_cache[dx] == undefined) {
          _cache[dx] = []
        }
        _cache[dx][dy] = data[n];
      }
      n++;
    }
  }

  function fetch(rx, ry){
    $.getJSON('map.json', function(data){
      processData(rx, ry, data)
    });
    console.log(_cache)
  }

  function render(x, y){
    for (var ry = y-hh; ry < y+hh; ry++) {
      for (var rx = x-hw; rx < x+hw; rx++) {
        if (_cache[rx] != undefined &&
           _cache[rx][ry] != undefined ) {
          console.log(_cache[rx][ry])
        } else {
          fetch(rx, ry);
        }
      }
    }
  }

  return {
    init: init,
    render: render
  }
}());

$(document).ready(function(){
  Maps.init(11, 11);
  Maps.render(6,6);
})
